@extends('layouts.app')
@section('title','Winguplus Apps')
@section('stylesheet')
   <link rel="stylesheet" href="{!! asset('assets/css/dashboard.css') !!}" />
@endsection
@section('content')
   @livewire('wingu.apps')
@endsection
@section('scripts')
   <script type="text/javascript">
      window.livewire.on('popModal', () => {
         $('#delete').modal('hide');
      });
   </script>
@endsection
