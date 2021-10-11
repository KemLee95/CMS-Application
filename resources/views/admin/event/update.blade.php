@extends('admin.master')
@section('head_style')
    <style>
        .stories-card__title, .stories-card .card-title, .stories-card .card-title > a {
            max-width: 350px;
        }
    </style>
@stop
@section('content')


<form id="sumit_form" action="/admin/save-event" method="POST">
<div class="row justify-content-center">
    {{ csrf_field() }}
    @if (isset($event) && $event)
        <input type="hidden" name="event_id" id="event_id" 
          value="{{isset($event->id) && $event->id ? $event->id : ""}}"
        >
        <input type="hidden" id="voucher_total" value={{isset($event->voucher_total) && $event->voucher_total ? $event->voucher_total : ""}}>
    @endif
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <div class="form-group">
            <label class="card-title" for="title">Event Name</label>
            <input id="name" type="text" class="form-control" name="name"
              value="{{isset($event) && $event->name ? $event->name : ""}}"
            >
          </div>
        </div>
        <div class="card-body">
          <div class="form-grpup">
            <label class="card-title" for="Description">Description</label>
            <textarea id="description" name="description" cols="30" rows="10" style="width: 100%">{{isset($event) && $event->description ? $event->description : ""}}</textarea>
          </div>
        </div>
      </div>
    </div>
    <div class="col-8 card">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Percentage Descrease</th>
            <th scope="col">Maximum Quanlity</th>
            <th scope="col">Expiry Date</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody id="voucher_container">
          <tr >
            <th>
              <button type="button" id="addPartial" class="btn btn-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
              </button>
            </th>
          </tr>

        </tbody>
      </table>
    </div>
</div>
@if (isset($user_auth) && $user_auth->isAdmin)
  <div class="float-right p-2">
    <button id="submit_button" type="button" class="btn btn-success">Submit</button>
  </div>
@endif
</form>
@stop
<section>

</section>
@section('foot_script')
<script>
  var eventId = $("#event_id").val();
  var voucherTotal = $("#voucher_total").val();
  
    function reIndex(){
      $(".index").each( function(idx) {
          $(this).text((idx + 1) + '/');
      });
    };

    function addDeleteEvent() {
      $(".delete_button").click(function(){
        let index = $(this).data("voucher_index");
        $(`#voucher_${index}`).remove();
        reIndex();
      });
    };

    function getNewPartial (index) {
      $.ajax({
          type: 'GET',
          async: true,
          url: `/admin/get-voucher-partial?index=${index}`,
        }).done(function(data){
          if(data) {
            $("#voucher_container").append(data);
            addDeleteEvent();
          }
      });
    }
    function initialParital() {

      let callback = function(paramObject, idx) {
        let {eventId} = paramObject;
        return {
          type: 'GET',
          url: `/admin/get-voucher-partial?event_id=${eventId}&page=${idx + 1}&paginate=1`,
          success: function(data) {
            if(data) {
              $("#voucher_container").append(data);
              addDeleteEvent();
            }
          }
        };
      };
      let paramObject = {
        eventId: eventId,
        maxNum: voucherTotal
      };
      sendAjax(callback, paramObject);
    }

    $(document).ready(function(){
      if(eventId) {
        initialParital();
      }else {
        getNewPartial(1);
      }

      $("#addPartial").click(function(){
        let index = $(".voucher_partial").length  + 1;
        getNewPartial(index);
      });

      function checkEmpty(ele, mess){
        let val =  $(ele).val();
        if(!val) {
          toastr.warning('Warning', mess);
          return true;
        }
        return false;
      };


      $("#submit_button").click(function(){

        let percentage = $(".percentage_decrease");
        let quanlity = $(".maximum_quantity");
        let expiryDate = $(".expiry_date");
        
        let isError = false;

        isError = checkEmpty("#name", "The name is required!");
        if(isError) return 0;

        isError = checkEmpty("#description", "The description is required!");
        if(isError) return 0;
        
        for(let idx = 0; idx < percentage.length; idx++) {
          let item = $(percentage[idx]);
          isError = checkEmpty(item, "The percentage_decrease is required!")
          if(isError) break;
        }
        if(isError) return 0;

        for(let idx = 0; idx < quanlity.length; idx++) {
          let item = $(quanlity[idx]);
          isError = checkEmpty(item, "The maximun_quanlity is required!")
          if(isError) break;
        }
        if(isError) return 0;

        for(let idx = 0; idx < expiryDate.length; idx++) {
          let item = $(expiryDate[idx]);
          isError = checkEmpty(item, "The expiry_date is required!")
          if(isError) break;
        }
        if(isError) return 0;

        $("#sumit_form").submit();
        
      });
    });

    function sendAjax(callback, paramObject, idx = 0) {
      let {maxNum} = paramObject;
      if(idx > maxNum -1) return false;
      $.ajax(
          callback(paramObject, idx)
      ).always(function() {
          sendAjax(callback, paramObject, ++idx);
      });
    };
</script>
@stop