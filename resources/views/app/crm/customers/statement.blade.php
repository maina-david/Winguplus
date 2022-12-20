<div class="row mt-3">
   <div class="col-md-12 mb-2">
      <a href="{!! route('crm.customers.statement.pdf',$code) !!}" class="btn btn-primary" title="pdf"><i class="fal fa-file-pdf"></i> pdf</a>
      <a href="{!! route('crm.customers.statement.print',$code) !!}" class="btn btn-warning" title="print"><i class="fal fa-print"></i> print</a>
      <a href="{!! route('crm.customers.statement.mail',$code) !!}" class="btn btn-pink" title="send email"><i class="fal fa-paper-plane"></i> Send mail</a>
   </div>
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="invoice-content">
               @include('templates.bootstrap-3.statement.preview')
            </div>
         </div>
      </div>
   </div>
</div>
