<?php $__env->startSection('stylesheet'); ?>
   <style>
      @media (min-width: 992px) {
         .inbox-wrapper .email-aside .aside-content {
            padding-right: 10px;
         }
      }

      .inbox-wrapper .email-aside .aside-content .aside-header {
         padding: 0 0 5px;
         position: relative;
      }

      .inbox-wrapper .email-aside .aside-content .aside-header .title {
         display: block;
         margin: 3px 0 0;
         font-size: 1.1rem;
         line-height: 27px;
         color: #686868;
      }

      .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle {
         background: 0 0;
         display: none;
         outline: 0;
         border: 0;
         padding: 0 11px 0 0;
         text-align: right;
         margin: 0;
         width: 100%;
         height: 100%;
         top: 0;
         left: 0;
         position: absolute;
      }

      @media (max-width: 991px) {
         .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle {
            display: block;
         }
      }

      .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle .icon {
         font-size: 24px;
         color: #71738d;
      }

      .inbox-wrapper .email-aside .aside-content .aside-compose {
         text-align: center;
         padding: 14px 0;
      }

      .inbox-wrapper .email-aside .aside-content .aside-compose .btn,
      .inbox-wrapper .email-aside .aside-content .aside-compose .fc .fc-button,
      .fc .inbox-wrapper .email-aside .aside-content .aside-compose .fc-button,
      .inbox-wrapper .email-aside .aside-content .aside-compose .swal2-modal .swal2-actions button,
      .swal2-modal .swal2-actions .inbox-wrapper .email-aside .aside-content .aside-compose button,
      .inbox-wrapper .email-aside .aside-content .aside-compose .wizard > .actions a,
      .wizard > .actions .inbox-wrapper .email-aside .aside-content .aside-compose a {
         padding: 11px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav {
         visibility: visible;
         padding: 0 0;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav.collapse {
         display: block;
      }

      @media (max-width: 991px) {
         .inbox-wrapper .email-aside .aside-content .aside-nav.collapse {
            display: none;
         }
      }

      @media (max-width: 991px) {
         .inbox-wrapper .email-aside .aside-content .aside-nav.show {
            display: block;
         }
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .title {
         display: block;
         color: #3d405c;
         font-size: 12px;
         font-weight: 700;
         text-transform: uppercase;
         margin: 20px 0 0;
         padding: 8px 14px 4px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li {
         width: 100%;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
         position: relative;
         color: #71748d;
         padding: 7px 14px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a:hover {
         text-decoration: none;
         background-color: rgba(114, 124, 245, 0.1);
         color: #727cf5;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .icon svg {
         width: 18px;
         margin-right: 10px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .badge {
         margin-left: auto;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a svg {
         width: 18px;
         margin-right: 10px;
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li.active a {
         color: #ff3366;
         background: rgba(255, 51, 102, 0.1);
      }

      .inbox-wrapper .email-aside .aside-content .aside-nav .nav li.active a .icon {
         color: #ff3366;
      }

      .inbox-wrapper .email-content .email-inbox-header {
         background-color: transparent;
         padding: 18px 18px;
      }

      .inbox-wrapper .email-content .email-inbox-header .email-title {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
         font-size: 1rem;
      }

      .inbox-wrapper .email-content .email-inbox-header .email-title svg {
         width: 20px;
         margin-right: 10px;
         color: #686868;
      }

      .inbox-wrapper .email-content .email-inbox-header .email-title .new-messages {
         font-size: .875rem;
         color: #686868;
         margin-left: 3px;
      }

      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .btn,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc .fc-button,
      .fc .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc-button,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .swal2-modal .swal2-actions button,
      .swal2-modal .swal2-actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn button,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .wizard > .actions a,
      .wizard > .actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn a {
         border-radius: 0;
         padding: 4.5px 10px;
      }

      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .btn svg,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc .fc-button svg,
      .fc .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .fc-button svg,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .swal2-modal .swal2-actions button svg,
      .swal2-modal .swal2-actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn button svg,
      .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn .wizard > .actions a svg,
      .wizard > .actions .inbox-wrapper .email-content .email-inbox-header .input-search .input-group-btn a svg {
         width: 18px;
      }

      .inbox-wrapper .email-content .email-filters {
         padding: 20px;
         border-bottom: 1px solid #e8ebf1;
         background-color: transparent;
         width: 100%;
         border-top: 1px solid #e8ebf1;
      }

      .inbox-wrapper .email-content .email-filters > div {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-left .btn-group,
      .inbox-wrapper .email-content .email-filters .email-filters-left .fc .fc-toolbar.fc-header-toolbar .fc-left .fc-button-group,
      .fc .fc-toolbar.fc-header-toolbar .fc-left .inbox-wrapper .email-content .email-filters .email-filters-left .fc-button-group,
      .inbox-wrapper .email-content .email-filters .email-filters-left .fc .fc-toolbar.fc-header-toolbar .fc-right .fc-button-group,
      .fc .fc-toolbar.fc-header-toolbar .fc-right .inbox-wrapper .email-content .email-filters .email-filters-left .fc-button-group {
         margin-right: 5px;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-left input {
         margin-right: 8px;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-right {
         text-align: right;
      }

      @media (max-width: 767px) {
         .inbox-wrapper .email-content .email-filters .email-filters-right {
            width: 100%;
            display: flex;
            justify-content: space-between;
         }
      }

      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-indicator {
         display: inline-block;
         vertical-align: middle;
         margin-right: 13px;
      }

      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .btn svg,
      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .fc .fc-button svg,
      .fc .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .fc-button svg,
      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .swal2-modal .swal2-actions button svg,
      .swal2-modal .swal2-actions .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav button svg,
      .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav .wizard > .actions a svg,
      .wizard > .actions .inbox-wrapper .email-content .email-filters .email-filters-right .email-pagination-nav a svg {
         width: 18px;
      }

      .inbox-wrapper .email-content .email-filters .be-select-all.custom-checkbox {
         display: inline-block;
         vertical-align: middle;
         padding: 0;
         margin: 0 30px 0 0;
      }

      .inbox-wrapper .email-content .email-list .email-list-item {
         display: -webkit-flex;
         display: flex;
         -webkit-align-items: center;
         align-items: center;
         border-bottom: 1px solid #e8ebf1;
         padding: 10px 20px;
         width: 100%;
         cursor: pointer;
         position: relative;
         font-size: 14px;
         cursor: pointer;
         transition: background .2s ease-in-out;
      }

      .inbox-wrapper .email-content .email-list .email-list-item:hover {
         background: rgba(114, 124, 245, 0.08);
      }

      .inbox-wrapper .email-content .email-list .email-list-item:last-child {
         margin-bottom: 5px;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions {
         width: 40px;
         vertical-align: top;
         display: table-cell;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .form-check {
         margin-bottom: 0;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .form-check i::before {
         width: 15px;
         height: 15px;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .form-check i::after {
         font-size: .8rem;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite {
         display: block;
         padding-left: 1px;
         line-height: 15px;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite span svg {
         width: 14px;
         color: #686868;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite:hover span {
         color: #8d8d8d;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-actions .favorite.active span svg {
         color: #fbbc06;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail {
         display: -webkit-flex;
         display: flex;
         -webkit-justify-content: space-between;
         justify-content: space-between;
         -webkit-flex-grow: 1;
         flex-grow: 1;
         -webkit-flex-wrap: wrap;
         flex-wrap: wrap;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .from {
         display: block;
         font-weight: 400;
         margin: 0 0 1px 0;
         color: #000;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .msg {
         margin: 0;
         color: #71738d;
         font-size: .8rem;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .date {
         color: #000;
      }

      .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .date .icon svg {
         width: 14px;
         margin-right: 7px;
         color: #3d405c;
      }

      .inbox-wrapper .email-content .email-list .email-list-item.email-list-item--unread {
         background-color: rgba(114, 124, 245, 0.09);
      }

      .inbox-wrapper .email-content .email-list .email-list-item.email-list-item--unread .from {
         color: #000;
         font-weight: 800;
      }

      .inbox-wrapper .email-content .email-list .email-list-item.email-list-item--unread .msg {
         font-weight: 700;
         color: #686868;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-header .navbar-toggle .icon {
         position: absolute;
         top: 0;
         left: 0;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav {
         padding-right: 0;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .icon svg {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a .badge {
         margin-left: 0;
         margin-right: auto;
      }

      .rtl .inbox-wrapper .email-aside .aside-content .aside-nav .nav li a svg {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .inbox-wrapper .email-content .email-inbox-header .email-title svg {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .inbox-wrapper .email-content .email-inbox-header .email-title .new-messages {
         margin-left: 0;
         margin-right: 3px;
      }

      .rtl .inbox-wrapper .email-content .email-filters .email-pagination-indicator {
         margin-right: 0;
         margin-left: 13px;
      }

      .rtl .inbox-wrapper .email-content .email-list .email-list-item .email-list-detail .date .icon svg {
         margin-right: 0;
         margin-left: 7px;
      }

      .email-head {
         background-color: transparent;
      }

      .email-head-subject {
         padding: 25px 25px;
         border-bottom: 1px solid #e8ebf1;
      }

      @media (max-width: 767px) {
         .email-head-subject {
            padding: 25px 10px;
         }
      }

      .email-head-subject .title {
         display: block;
         font-size: .99rem;
      }

      .email-head-subject .title a.active .icon {
         color: #fbbc06;
      }

      .email-head-subject .title a .icon {
         color: silver;
         margin-right: 6px;
      }

      .email-head-subject .title a .icon svg {
         width: 18px;
      }

      .email-head-subject .icons {
         font-size: 14px;
         float: right;
      }

      .email-head-subject .icons .icon {
         color: #000;
         margin-left: 12px;
      }

      .email-head-subject .icons .icon svg {
         width: 18px;
      }

      .email-head-sender {
         padding: 13px 25px;
      }

      @media (max-width: 767px) {
         .email-head-sender {
            padding: 25px 10px;
         }
      }

      .email-head-sender .avatar {
         float: left;
         margin-right: 10px;
      }

      .email-head-sender .date {
         float: right;
         font-size: 12px;
      }

      .email-head-sender .avatar {
         float: left;
         margin-right: 10px;
      }

      .email-head-sender .avatar img {
         width: 36px;
      }

      .email-head-sender .sender > a {
         color: #000;
      }

      .email-head-sender .sender span {
         margin-right: 5px;
         margin-left: 5px;
      }

      .email-head-sender .sender .actions {
         display: inline-block;
         position: relative;
      }

      .email-head-sender .sender .actions .icon {
         color: #686868;
         margin-left: 7px;
      }

      .email-head-sender .sender .actions .icon svg {
         width: 18px;
      }

      .email-body {
         background-color: transparent;
         border-top: 1px solid #e8ebf1;
         padding: 30px 28px;
      }

      @media (max-width: 767px) {
         .email-body {
            padding: 30px 10px;
         }
      }

      .email-attachments {
         background-color: transparent;
         padding: 25px 28px 5px;
         border-top: 1px solid #e8ebf1;
      }

      @media (max-width: 767px) {
         .email-attachments {
            padding: 25px 10px 0;
         }
      }

      .email-attachments .title {
         display: block;
         font-weight: 500;
      }

      .email-attachments .title span {
         font-weight: 400;
      }

      .email-attachments ul {
         list-style: none;
         margin: 15px 0 0;
         padding: 0;
      }

      .email-attachments ul > li {
         margin-bottom: 5px;
      }

      .email-attachments ul > li:last-child {
         margin-bottom: 0;
      }

      .email-attachments ul > li a {
         color: #000;
      }

      .email-attachments ul > li a svg {
         width: 18px;
         color: #686868;
      }

      .email-attachments ul > li .icon {
         color: #737373;
         margin-right: 2px;
      }

      .email-attachments ul > li span {
         font-weight: 400;
      }

      .rtl .email-head-subject .title a .icon {
         margin-right: 0;
         margin-left: 6px;
      }

      .rtl .email-head-subject .icons .icon {
         margin-left: 0;
         margin-right: 12px;
      }

      .rtl .email-head-sender .avatar {
         margin-right: 0;
         margin-left: 10px;
      }

      .rtl .email-head-sender .sender .actions .icon {
         margin-left: 0;
         margin-right: 7px;
      }

      .email-head-title {
         padding: 15px;
         border-bottom: 1px solid #e8ebf1;
         font-weight: 400;
         color: #3d405c;
         font-size: .99rem;
      }

      .email-head-title .icon {
         color: #696969;
         margin-right: 12px;
         vertical-align: middle;
         line-height: 31px;
         position: relative;
         top: -1px;
         float: left;
         font-size: 1.538rem;
      }

      .email-compose-fields {
         background-color: transparent;
         padding: 20px 15px;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered {
         margin: -2px -14px;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
         border-radius: 0;
         background: #727cf5;
         color: #ffffff;
         margin-top: 0px;
         padding: 4px 10px;
         font-size: 13px;
         border: 0;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice span {
         color: #ffffff;
      }

      .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-search {
         line-height: 15px;
      }

      .form-group.row {
         margin-bottom: 0;
         padding: 12px 0;
      }

      .form-group.row label {
         white-space: nowrap;
      }

      .email-compose-fields label {
         padding-top: 6px;
      }

      .email.editor {
         background-color: transparent;
      }

      .email.editor .editor-statusbar {
         display: none;
      }

      .email.action-send {
         padding: 8px 0px 0;
      }

      .btn-space {
         margin-right: 5px;
         margin-bottom: 5px;
      }

      .breadcrumb {
         margin: 0;
         background-color: transparent;
      }

      .rtl .email-compose-fields .select2-container--default .select2-selection--multiple .select2-selection__rendered .select2-selection__choice {
         float: right;
      }

      .rtl .btn-space {
         margin-right: 0;
         margin-left: 5px;
      }
      .card {
         box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
         -webkit-box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
         -moz-box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
         -ms-box-shadow: 0 0 10px 0 rgba(183, 192, 206, 0.2);
      }
      .card {
         position: relative;
         display: flex;
         flex-direction: column;
         min-width: 0;
         word-wrap: break-word;
         background-color: #fff;
         background-clip: border-box;
         border: 1px solid #f2f4f9;
         border-radius: 0.25rem;
      }
      .badge {
         padding: 6px 5px 3px;
      }
      .text-white {
         color: #ffffff !important;
      }
      .font-weight-bold {
         font-weight: 700 !important;
      }
      .float-right {
         float: right !important;
      }
      .badge-danger-muted {
         color: #212529;
         background-color: #f77eb9;
      }
   </style>
<?php $__env->stopSection(); ?>
<div class="col-md-12 mt-3">
   <div class="row inbox-wrapper">
      <div class="col-lg-12">
         <div class="card">
            <div class="card-body">
               <div class="row">
                  <?php echo $__env->make('app.crm.leads.mail._sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  <div class="col-lg-9 email-content">
                     <ul class="mail_list list-group list-unstyled">
                        <?php $__currentLoopData = $mails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <li class="list-group-item">
                              <div class="media">
                                 <div class="pull-left">
                                    <div class="thumb">
                                       <?php if($lead->image != ""): ?>
                                          <img class="rounded-circle" alt="" class="<?php echo $lead->names; ?>" src="<?php echo asset('businesses/'.$lead->primary_email.'/clients/'.$lead->customer_code.'/images/'.$lead->image); ?>" style="width:50px;height:50px">
                                       <?php else: ?>
                                          <img src="https://ui-avatars.com/api/?name=<?php echo $lead->customer_name; ?>&rounded=true&size=50 alt="">
                                       <?php endif; ?>
                                    </div>
                                 </div>
                                 <div class="media-body">
                                    <div class="media-heading">
                                       <a href="<?php echo route('crm.leads.details',[$mail->mail_code,$code]); ?>" class="m-r-10"><?php echo $mail->names; ?></a>
                                       <?php if($mail->status == "Sent"): ?>
                                          <span class="badge bg-green">Sent</span>
                                       <?php else: ?>
                                       <span class="badge bg-orange">Draft</span>
                                       <?php endif; ?>
                                       <small class="float-right text-muted">
                                          <time class="hidden-sm-down" datetime="2017"><?php echo date('F d, Y @ h:i:s A', strtotime($mail->created_at)); ?></time>
                                          <i class="fal fa-paperclip"></i>
                                       </small>
                                    </div>
                                    <p class="msg"><?php echo $mail->subject; ?><br><span class="text-pink">View Date : <?php echo date('F jS, Y',strtotime($mail->date_view)); ?></span> | <span class="text-info">View Count : <?php echo $mail->view_count; ?></span></p>
                                 </div>
                              </div>
                           </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="row mt-2">
                     <div class="col-md-12">
                        <?php if($mails->lastPage() > 1): ?>
                           <nav aria-label="...">
                              <ul class="pagination">
                                 <li class="page-item">
                                    <a class="page-link" href="<?php echo e($mails->url(1)); ?>">Previous</a>
                                 </li>
                                 <?php for($i = 1; $i <= $mails->lastPage(); $i++): ?>
                                    <li class="page-item <?php echo e(($mails->currentPage() == $i) ? 'active' : ''); ?>">
                                       <a class="page-link" href="<?php echo e($mails->url($i)); ?>">
                                             <?php echo e($i); ?>

                                          <span class="sr-only">(current)</span>
                                       </a>
                                    </li>
                                 <?php endfor; ?>
                                 <li class="page-item">
                                    <a class="page-link" href="<?php echo e($mails->url($mails->currentPage()+1)); ?>">Next</a>
                                 </li>
                              </ul>
                           </nav>
                        <?php endif; ?>
                     </div>
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php /**PATH /var/www/winguplus/cloud.winguplus.com/resources/views/app/crm/leads/mail/index.blade.php ENDPATH**/ ?>