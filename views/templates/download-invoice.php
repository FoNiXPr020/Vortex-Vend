<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="utf-8">
        <title>Invoice <?= $params['buyer_username']; ?></title>
        <style>
        .clearfix:after {
          content: "";
          display: table;
          clear: both;
        }
        
        a {
          color: #5D6975;
          text-decoration: underline;
        }
        
        body {
          position: relative;
          width: 15cm;
          height: 17cm;
          margin: 31px auto;
          color: #001028;
          background: #FFFFFF;
          font-family: Arial, sans-serif;
          font-size: 12px;
          font-family: Arial;
        }
        
        header {
          padding: 10px 0;
          margin-bottom: 30px;
        }
        
        #logo {
          text-align: center;
          margin-bottom: 10px;
        }
        
        #logo img {
          width: 90px;
        }
        
        h1 {
          border-top: 1px solid  #5D6975;
          border-bottom: 1px solid  #5D6975;
          color: #5D6975;
          font-size: 2.4em;
          line-height: 1.4em;
          font-weight: normal;
          text-align: center;
          margin: 0 0 20px 0;
          background: url(dimension.png);
        }
        
        #project {
          float: left;
        }
        
        #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 10px;
          display: inline-block;
          font-size: 0.8em;
        }

        #project div,
        #company div {
          white-space: nowrap;        
        }
        
        table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
        }
        
        table tr:nth-child(2n-1) td {
          background: #F5F5F5;
        }
        
        table th,
        table td {
          text-align: center;
        }
        
        table th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: nowrap;        
          font-weight: normal;
        }
        
        table .service,
        table .desc {
          text-align: left;
        }
        
        table td {
          padding: 20px;
          text-align: right;
        }
        
        table td.service,
        table td.desc {
          vertical-align: top;
        }
        
        table td.unit,
        table td.qty,
        table td.total {
          font-size: 1.2em;
        }
        
        table td.grand {
          border-top: 1px solid #5D6975;;
        }
        
        #notices .notice {
          color: #5D6975;
          font-size: 1.2em;
        }
        
        footer {
          color: #5D6975;
          width: 100%;
          height: 30px;
          position: absolute;
          bottom: 0;
          border-top: 1px solid #C1CED9;
          padding: 8px 0;
          text-align: center;
        }
        </style>
      </head>
      <body>
        <header class="clearfix">
          <h1>Vortex Vend</h1>
          <h2>Purchase Details:</h2>
          <div id="project">
            <div><span>PROJECT</span>Vortex Vend</div>
            <div><span>CLIENT</span><?= $params['buyer_username']; ?></div>
            <div><span>PAYMENT ID</span><?= $params['transaction_token']; ?></div>
            <div><span>EMAIL</span><?= $params['buyer_email']; ?></div>
            <div><span>PHONE</span><?= $params['buyer_phone']; ?></div>
            <div><span>DATE</span><?= $params['transaction_date']; ?></div>
          </div>
        </header>
        <main>
          <table>
            <thead>
              <tr>
                <th class="service">PRODUCT</th>
                <th class="desc">DESCRIPTION</th>
                <th>PRICE</th>
                <th>QTY</th>
                <th>TOTAL</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="service"><?= $params['product_name']; ?></td>
                <td class="desc"><?= $params['description']; ?></td>
                <td class="unit"><?= $params['price']; ?>$</td>
                <td class="qty"><?= $params['quantity']; ?></td>
                <td class="total"><?= $params['price']; ?>$</td>
              </tr>
            </tbody>
          </table>
          <div id="notices">
            <div>NOTICE:</div>
            <div class="notice">No tax included (see our Terms and Conditions for more details)</div>
          </div>
        </main>
        <footer>
          Invoice was created on a computer and is valid without the signature and seal.
        </footer>
      </body>
    </html>