<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Document</title>
</head>
<body>
      <style type="text/css">
         body
         {
         margin: 0px 0px 0px 0px;
         padding: 0px 0px 0px 0px;
         }
         .print_page_container
         {
         font-size: 18px;
         width: 100%;
         font-family: Candara, Calibri, Segoe, 'Segoe UI', Optima, Arial, sans-serif;
         text-align: left;
         color: #000000;
         }
         .section
         {
         width: 100%;
         margin-bottom: 20px;
         padding: 0 0;
         border-collapse: collapse;
         border-spacing: 0;
         /*page-break-inside: avoid;*/
         }
         .leftbox, .rightbox
         {
         width: 48%;
         background-color: #F3F3F3;
         }
         .middlebox
         {
         width: 4%;
         }
         .customer_section, .contact_section
         {
         width: 100%;
         border: 0px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         }
         .print_heading, .ticket_heading, .mycompany_heading
         {
         text-align: left;
         font-weight: bold;
         color: #000000;
         background-color: #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         border-bottom: 0px;
         border-top: 1px solid #CCCCCC;
         border-left: 1px solid #CCCCCC;
         border-right: 1px solid #CCCCCC;
         padding: 3px 3px;
         }
         .customer_body
         {
         padding: 3px 3px;
         }
         .amountdue_section
         {
         text-align: right;
         border: 2px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         }
         .ticket_section, .item_section, .asset_section, .appointment_section
         {
         width: 100%;
         text-align: left;
         border: 0px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         }
         .customer_label
         {
         display:none;
         text-align: left;
         font-weight: bold;
         color: #000000;
         background-color: #FFFFFF;
         vertical-align: top;
         white-space: nowrap;
         }
         .ticket_label, .ticket_label2, .wolabel, .amountdue_label, .asset_label
         {
         text-align: left;
         vertical-align: top;
         font-weight: bold;
         color: #000000;
         background-color: #FFFFFF;
         white-space: nowrap;
         border: 1px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         padding: 2px 2px;
         }
         .ticket_text, .ticket_text2, .wotext, .wotext_number, .amountdue_text, .asset_text
         {
         text-align: left;
         vertical-align: top;
         color: #000000;
         background-color: #FFFFFF;
         border: 1px solid #CCCCCC;
         border-collapse: collapse;
         border-spacing: 0;
         padding: 2px 2px;
         }
         .ticket_label, .ticket_label2
         {
         width: 10%;
         }
         .ticket_text, .ticket_text2
         {
         width: 40%;
         }
         .customer_label
         {
         width: 10%;
         margin-left: 10px;
         }
         .customer_text
         {
         width: 40%;
         }
         .asset_label
         {
         width: 20%;
         }
         .asset_text
         {
         width: 80%;
         }
         .wotext_number
         {
         text-align: right;
         white-space: nowrap;
         }
         .wotext, .wotext_number
         {
         padding-top: 3px;
         padding-bottom: 3px;
         padding-left: 3px;
         padding-right: 3px;
         }
         .my_company_info
         {
         font-weight: bold;
         color: #000000;
         background-color: #FFFFFF;
         }
         .customer_section, .customer_label, .customer_text, .contact_section, .wolabel
         {
         text-align: left;
         background-color: #F3F3F3;
         }
         .amountdue_label
         {
         text-align: right;
         }
         .ticket_info
         {
         font-family: "Arial Rounded MT Bold";
         color: #DDDDDD;
         text-align: center;
         }
         .largeHeader
         {
         }
         .subtotal_label
         {
         font-family: Arial;
         font-weight: bold;
         text-align: right;
         white-space: nowrap;
         }
         .subtotal_text
         {
         border-bottom: solid 1px #999999;
         text-align: right;
         }
         .signature
         {
         width: 216px;
         page-break-inside: avoid;
         }
         .my_company_logo img
         {
         width: 200px;
         height: auto;
         }
         .f1{
         color: #939598;
         }
         #item td{
         font-size: 13px;
         border: 1px solid #ffffff;
         padding: 5px;
         }
         #item table tr:nth-child(even) td{
         background-color: #e0e1e3;
         }
         #item table tr:nth-child(odd) td{
         background-color: #e0e1e3;
         }
         #item table tr td:last-child{
         background-color: #3979B6;
         text-align:center;
         color: #000000;
         font-weight:bold;
         }
         #item table tr:first-child td{
         background-color: #474a4e;
         text-align:center;
         color: #ffffff;
         margin-bottom: 0;
         }
         </style>
         <div class="print_page_container">
         <!-- add this div to the header input field-->
         <table style="table-layout: fixed; width: 100%; margin-bottom: 5px; background-color: #ffffff;">
         <tbody>
         <tr>
         <td style="color: #3979b6; text-align: left; padding-left: 10px;"><strong>ESTIMATE # _EstimateID_</strong></td>
         <td style="text-align: center; padding: 5px;" class="my_company_logo">
         _MyCompanyLogo_<br />
         </td>
         <td style="text-align: right; color: #3979b6; padding-right: 10px; font-size: 12px;">_MyCompanyName_<br />
         _MyCompanyAddress_<br />
         _MyCompanyPhone_</td>
         </tr>
         </tbody>
         </table>
         <span style="float: right; padding-right: 20px; font-size: 13px;" class="f1"></span><br style="line-height: 8px;" />
         <span style="float: right; padding-right: 20px; font-size: 13px;" class="f1">Valid for 30 days</span>
         <table class="section">
         <tbody>
         <tr>
         <td style="width: 20%; text-align: right;"><span class="f1">Client Name: </span></td>
         <td style="width: 80%; text-align: left; padding-left: 10px;"><span>_CustomerName_</span></td>
         </tr>
         <tr>
         <td style="width: 20%; text-align: right;"><span class="f1">Address: </span></td>
         <td style="width: 80%; text-align: left; padding-left: 10px;"><span>_CustomerAddress_</span></td>
         </tr>
         <tr>
         <td style="width: 20%; text-align: right;"><span class="f1">Phone: </span></td>
         <td style="width: 80%; text-align: left; padding-left: 10px;"><span>_CustomerPhone_</span></td>
         </tr>
         <tr>
         <td style="width: 20%; text-align: right;"><span class="f1">Email: </span></td>
         <td style="width: 80%; text-align: left; padding-left: 10px;"><span>_CustomerEmail_</span></td>
         </tr>
         </tbody>
         </table>
         <table class="section">
         <tbody>
         <tr>
         <td style="width: 2%;"> </td>
         <td id="item" style="width: 96%;">_Items_</td>
         <td style="width: 2%;"> </td>
         </tr>
         </tbody>
         </table>
         <table class="section">
         <tbody>
         <tr>
         <td style="width: 2%;"> </td>
         <td style="width: 96%;">
         <table bordercolor="#ffffff" border="1" class="section">
         <tbody>
         <tr>
         <td style="width: 485px;"> </td>
         <td style="text-align: center; font-size: 13px; width: 96px; padding: 5px; background-color: #e0e1e3;">Subtotal</td>
         <td style="text-align: center; font-size: 13px; padding: 5px; background-color: #e0e1e3;"><strong>_Estimate.Subtotal_<br />
         </strong></td>
         </tr>
         <tr>
         <td style="width: 485px;"> </td>
         <td style="text-align: center; font-size: 13px; width: 96px; padding: 5px; background-color: #e0e1e3;">Tax</td>
         <td style="text-align: center; font-size: 13px; padding: 5px; background-color: #e0e1e3;"><strong>_tax_</strong></td>
         </tr>
         <tr>
         <td style="width: 485px;"> </td>
         <td style="text-align: center; color: #000000; font-size: 13px; width: 96px; padding: 5px;"><strong>TOTAL</strong></td>
         <td style="text-align: center; font-size: 13px; padding: 5px; background-color: #3979b6;"><strong>_total_</strong></td>
         </tr>
         </tbody>
         </table>
         </td>
         <td style="width: 2%;"> </td>
         </tr>
         </tbody>
         </table>
         <table class="section">
         <tbody>
         <tr>
         <td style="width: 2%;"> </td>
         <td style="width: 96%;">
         <span style="float: left; padding-right: 20px;" class="f1">NOTES</span>
         </td>
         <td style="width: 2%;"> </td>
         </tr>
         <tr>
         <td style="width: 2%;">&nbsp;</td>
         <td style="width: 96%;">&nbsp;_EstimateNotes_</td>
         <td style="width: 2%;">&nbsp;</td>
         </tr>
         </tbody>
         </table>
         <!-- add this div to the footer input field-->
         <div style="min-height: 20px; background-color: #474a4e;">&nbsp;</div>
         </div>
         
         
</body>
</html>