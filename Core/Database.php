<?php

/**
 * Database - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

use Dotenv\Dotenv;

class Database
{
    private static $instance = null;
    private $conn;
    private $cache;
    private $allUsersKey;
    private $cacheEnabled;

    private function __construct()
    {
        // Load environment variables from .env file
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();

        // Set database credentials from environment variables
        $dbConfig = [
            'host' => $_ENV['DB_HOST'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'database' => $_ENV['DB_TABLE'],
            'port' => $_ENV['DB_PORT'] ?? 3306 // Default port if not specified
        ];

        // Create connection
        $this->conn = new \mysqli($dbConfig['host'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database'], $dbConfig['port']);

        // Check connection
        if ($this->conn->connect_error) {
            throw new \Exception("Database connection failed: " . $this->conn->connect_error);
        }

        $this->cache = new Caching();
        $this->allUsersKey = $_ENV['ALL_USERS'] ?? '';
        $this->cacheEnabled = (int) ($_ENV['CACHE_SYSTEM'] ?? 0);
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function Count($table)
    {
        if ($this->cacheEnabled) {
            $count = count($this->cache->get($this->allUsersKey));
            return $count;
        }

        // If caching is not enabled, count items from the database
        $sql = "SELECT COUNT(*) AS total FROM $table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the count from the database result
        $row = $result->fetch_assoc();
        $totalUsers = $row['total'];

        // Close the statement
        $stmt->close();

        return $totalUsers;
    }

    public function Query($sql, $bindParams = array(), $queryType = 'SELECT')
    {
        // Prepare the query
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing SQL statement: " . $this->conn->error;
            return false;
        }

        // Bind parameters if provided
        if (!empty($bindParams)) {
            $bindTypes = str_repeat('s', count($bindParams)); // Assuming all values are strings
            $stmt->bind_param($bindTypes, ...$bindParams);
        }

        // Execute the query
        if ($stmt->execute()) {
            if ($queryType === 'SELECT') {
                // For SELECT queries
                $result = $stmt->get_result();

                // Fetch data
                $records = [];
                while ($row = $result->fetch_assoc()) {
                    $records[] = $row;
                }

                // Close the statement
                $stmt->close();

                return $records;
            } elseif ($queryType === 'UPDATE' || $queryType === 'DELETE') {
                // For UPDATE or DELETE queries
                $affectedRows = $stmt->affected_rows;

                // Close the statement
                $stmt->close();

                return $affectedRows;
            } elseif ($queryType === 'INSERT') {
                // For INSERT queries, return the inserted ID
                $insertedId = mysqli_insert_id($this->conn);

                // Close the statement
                $stmt->close();

                return $insertedId;
            } else {
                // Unsupported query type
                echo "Unsupported query type: $queryType";
                $stmt->close();
                return false;
            }
        } else {
            echo "Error executing SQL query: " . $stmt->error;
            return false;
        }
    }

    public function Insert($table, $data, $returnUserId = false)
    {
        // Check if the data to insert is empty
        if (empty($data)) {
            echo "No data to insert<br>";
            return;
        }

        // Construct the INSERT query
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing insert statement: " . $this->conn->error;
            return;
        }

        // Bind parameters for the insert query
        $bindParams = array_values($data);
        $bindTypes = str_repeat('s', count($bindParams)); // Assuming all values are strings
        $stmt->bind_param($bindTypes, ...$bindParams);

        // Execute the insert query
        if ($stmt->execute()) {
            //echo "Record inserted successfully<br>";

            // Update cache if enabled
            if ($this->cacheEnabled && $this->cache->get($this->allUsersKey)) {
                // Retrieve current cached data
                $cachedData = $this->cache->get($this->allUsersKey);

                // Insert the new record into cached data
                $lastInsertedId = $this->conn->insert_id;
                $cachedData[$lastInsertedId] = $data;

                // Save the updated data back to the cache
                $cacheItem = $this->cache->get($this->allUsersKey);
                $cacheItem->set($cachedData);
            }

            if ($returnUserId) {
                $lastInsertedId = $stmt->insert_id;

                // Return the last inserted ID
                return $lastInsertedId;
            }
            return true;
        } else {
            echo "Error inserting record: " . $stmt->error;
        }

        $stmt->close();
    }

    public function Update($table, $idColumn, $dataToUpdate, $idToUpdate)
    {
        // Construct the SET clause for the update query
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = ?";
        }, array_keys($dataToUpdate)));

        // Construct the update query
        $sql = "UPDATE $table SET $setClause WHERE $idColumn = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing update statement: " . $this->conn->error;
            return;
        }

        // Bind parameters for the update query
        $bindParams = array_values($dataToUpdate);
        $bindParams[] = $idToUpdate; // Add the ID to the end
        $bindTypes = str_repeat('s', count($bindParams)); // Assuming all values are strings
        $stmt->bind_param($bindTypes, ...$bindParams);

        // Execute the update query
        if ($stmt->execute()) {
            echo "Record updated successfully<br>";

            // Update cache if enabled
            if ($this->cacheEnabled && $this->cache->get($this->allUsersKey)) {
                $this->updateCache($idToUpdate, $dataToUpdate);
            }

            return true;
        } else {
            echo "Error updating record: " . $stmt->error;
            return false;
        }

        $stmt->close();
    }

    public function Select($table, $columns = "*", $conditions = "", $bindParams = array())
    {
        // Check if caching is enabled and cache has the data
        if ($this->cacheEnabled && $this->cache->get($this->allUsersKey)) {
            return $this->cache->get($this->allUsersKey);
        }

        // Construct the SELECT query
        $sql = "SELECT $columns FROM $table";

        // Add conditions if provided
        if (!empty($conditions)) {
            $sql .= " WHERE $conditions";
        }

        // Prepare the SELECT query
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing SELECT statement: " . $this->conn->error;
            return;
        }

        // Bind parameters if provided
        if (!empty($bindParams)) {
            $bindTypes = str_repeat('s', count($bindParams)); // Assuming all values are strings
            $stmt->bind_param($bindTypes, ...$bindParams);
        }

        // Execute the SELECT query
        if ($stmt->execute()) {
            // Get the result set
            $result = $stmt->get_result();

            // Fetch data
            $records = [];
            while ($row = $result->fetch_assoc()) {
                if ($columns == "*" && $conditions == "") {
                    // Only fetch the specified columns
                    $records[$row['id']] = $row;
                } else {
                    // Store user data by user ID
                    $records = $row;
                }
            }

            // Cache the data if caching is enabled
            if ($this->cacheEnabled) {
                $cacheItem = $this->cache->get($this->allUsersKey);
                $cacheItem->set($records);
            }

            return $records;
        }
        // Close the statement
        $stmt->close();
    }

    public function Exists($table, $column, $value)
    {
        if ($this->cacheEnabled && $this->cache->has($this->allUsersKey)) {
            $allUserData = $this->cache->get($this->allUsersKey);

            foreach ($allUserData as $userData) {
                if ($userData[$column] === $value) {
                    return true; // Record exists
                }
            }
        }

        $sql = "SELECT COUNT(*) AS count FROM $table WHERE $column = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            echo "Error preparing SELECT statement: " . $this->conn->error;
            return false;
        }

        $stmt->bind_param("s", $value);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();

            $recordExists = ($row['count'] > 0);

            $stmt->close();

            return $recordExists;
        } else {
            echo "Error executing SELECT query: " . $stmt->error;
            return false;
        }
    }

    private function updateCache($idToUpdate, $dataToUpdate, $UsersKey = null)
    {
        // Determine the cache key
        $cacheKey = $UsersKey ?? $this->allUsersKey;

        // Retrieve current cached data
        $cachedData = $this->cache->get($cacheKey);

        // Update the cached data with new changes
        if (isset($cachedData[$idToUpdate])) {
            foreach ($dataToUpdate as $key => $value) {
                $cachedData[$idToUpdate][$key] = $value;
            }
        }

        // Save the updated data back to the cache
        $cacheItem = $this->cache->get($cacheKey);
        $cacheItem->set($cachedData);
    }
}
