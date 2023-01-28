
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example 1</title>
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
  width: 18cm;
  height: 29.7cm;
  margin: 0 auto;
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
  background: url(https://i.postimg.cc/Bb3CNB1K/dimension.png);
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

#company {
  float: right;
  text-align: right;
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
      <div id="logo">
        <img width="150" src="https://i.postimg.cc/ry4bJf7K/logo.png">
      </div>
      <h1>INVOICE ID: {{ $order_info->order_id }}</h1>
      <div id="company" class="clearfix">
        <div>Sparrow Online Shop</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
        <div><span>Bill To:</span></div>
        <div><span>NAME</span> {{ $billing_info->first()->name }}</div>
        <div><span>ADDRESS</span> {{ $billing_info->first()->address }}</div>
        <div><span>EMAIL</span> <a href="mailto:{{ $billing_info->first()->email }}">{{ $billing_info->first()->email }}</a></div>
        <div><span>DATE</span> {{ $billing_info->first()->created_at->format('d-m-Y') }}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="desc">ITEM</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
        @php
            $sub = 0;
        @endphp
         @foreach ($order_product as $product_info)
          <tr>
            <td class="desc">{{ $product_info->rel_to_product->product_name }}</td>
            <td class="unit">{{ $product_info->price }}</td>
            <td class="qty">{{ $product_info->quantity }}</td>
            <td class="total">{{ $product_info->price*$product_info->quantity }}</td>
          </tr>
          @php
            $sub += $product_info->price*$product_info->quantity;
          @endphp
          @endforeach
          <tr>
            <td colspan="3">SUBTOTAL</td>
            <td class="total">{{ $sub }}</td>
          </tr>
          <tr>
            <td colspan="3">Discount</td>
            <td class="total">{{ $order_info->discount }}</td>
          </tr>
          <tr>
            <td colspan="3">Charge</td>
            <td class="total">{{ $order_info->charge }}</td>
          </tr>
          <tr>
            <td colspan="3" class="grand total">GRAND TOTAL</td>
            <td class="grand total">{{ $order_info->total }}</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>
