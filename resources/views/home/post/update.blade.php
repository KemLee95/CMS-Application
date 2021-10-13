@extends('admin.master')
@section('head_style')
<style>
  .bg-black {
    background-color: rgba(0,0,0,.01);
  }
  .border-black {
    border-color: rgba(0,0,0,.03);
  }
  .border-solid {
    border-style: solid;
  }
  .border-radius {
    border-radius: .5rem
  }
  .magrin-bt {
    margin-bottom: .5rem;
  }
  .active {
    background-color: #ffc107 !important
  }
</style>
@stop
@section('content')

<div class="row {{isset($post) && $post && isset($user_auth) && $user_auth ? "": "justify-content-center"}}">
  <div class="border-black border-solid col-8 card border-radius magrin-bt">
    <input id="user_auth_id" type="hidden"  value={{isset($user_auth)&& $user_auth->id ? $user_auth->id : ""}}>
    <form id="postsForm" action="save-post" method="POST">
      {{ csrf_field() }}
      @if ($post)
      <input id="post_id" type="hidden" name="id" value={{isset($post)&& $post->id ? $post->id : ""}}>
      <input id="can_update" type="hidden" value={{isset($canUpdate) && $canUpdate ? $canUpdate : ""}}>
      @endif
      <div class="card-header">
        <div class="row form-group">
          <div class="col-12">
            <label for="categories">
              <strong>
                Categories
              </strong>
            </label>
          </div>
          <div class="col-12">
            <select class="form-control" id="category_id" style="width: 100%" name="category_id">
              <option value="">Select the category</option>
              @if (isset($categories) && $categories)
                  @foreach ($categories as $category)
                      <option {{isset($post->category_id) && ($post->category_id == $category->id) ? "selected":"" }} value="{{isset($category->id) && $category->id ? $category->id :""}}">{{isset($category->name) && $category->name ? $category->name :""}}</option>
                  @endforeach
              @endif
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <label for="title"><strong>Tittle</strong></label>
            <h5>
              <textarea class="form-control" id="post_title" name="title" rows="2">{{isset($post->title) && $post->title ? $post->title :""}}</textarea>
            </h5>
          </div>
          <div class="col-12 text-nowrap text-truncate text-capitalize">
            <div class="d-flex align-items-center justify-content-between">
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-secondary 
                {{isset($post->status) && $post->status == 'draft' ? "active":""}}"
                >
                  <input onclick="javascript: return false;" type="radio" value="draft" name="status" class="status" autocomplete="off" {{isset($post->status) && $post->status === 'draft' ? "checked":""}}>
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                      <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                      <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                  </span>
                </label>
                <label class="btn btn-secondary 
                  {{isset($post->status) && $post->status === "published" ? "active":""}} "
                >
                  <input type="radio" value="published" name="status" class="status" autocomplete="off" 
                    {{isset($post->status) && $post->status === 'published' ? "checked":""}}
                    {{ (isset($user_auth->isAdmin) && 
                      ($user_auth->id !== (isset($post->user_id) && $post->user_id ? $post->user_id : false))) 
                      && (isset($post->status) && $post->status == 'draft') ? "disabled":""
                    }}
                  >
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                      <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                    </svg>
                  </span>
                </label>
                <label class="btn btn-secondary 
                  {{isset($post->status) && $post->status == 'unpublished' ? "active":""}}"
                >
                  <input type="radio" value="unpublished" name="status" class="status" autocomplete="off" 
                    {{isset($post->status) && $post->status === 'unpublished' ? "checked":""}}
                    {{ (isset($user_auth->isAdmin) 
                      && ($user_auth->id !== (isset($post->user_id) && $post->user_id ? $post->user_id : false))) 
                      && (isset($post->status) && $post->status == 'draft') ? "disabled":""
                    }}
                  >
                  <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                      <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                    </svg>
                  </span>
                </label>
              </div>
              <div >
                @if (isset($post) && $post)
                  <strong>Author: {{isset($post->user_name) && $post->user_name ? $post->user_name :""}}</strong>            
                  <span class="p-1 border-radius btn-info">{{ isset($post->updated_at) && $post->updated_at ?  date('d/m/Y', strtotime($post->updated_at)) : "" }}</span>
                @endif
              </div>
            </div>
          </div>
          @if (isset($editingUser) && $editingUser)
            <div class="py-4 col-12">
              <span >
                <img style="width: 30px; height: 30px" src="/assets/images/live.png" alt="">
                <strong>Being editor by:</strong>
                <span>{{isset($editingUser->user_name) && $editingUser->user_name ? $editingUser->user_name : ""}}</span>
              </span>
            </div>
          </div>
          @endif
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="content">
            <strong>Content</strong>
          </label>
          <textarea class="form-control" id="post_content" name="content" rows="10">{{isset($post->content) && $post->content ? $post->content :""}}</textarea>
        </div>
      </div>
      <div class="card-body">
        @if (isset($canUpdate) && $canUpdate)
        <button id="submit_button" type="button" class="btn w-100 btn-success" >
          Update
        </button>
        @elseif( $user_auth &&!$post)
          <button id="submit_button" type="button" class="btn w-100 btn-success">Save</button>
        @endif
      </div>
    </form>
  </div>
  @if (isset($post) && $post && isset($user_auth) && $user_auth)
    <input id="events" type="hidden" value="{{isset($avaibleEventTotal) && $avaibleEventTotal ? $avaibleEventTotal : ""}}">
    <div class="col-4">
      <div class="card">
        <div class="card-header">
          <strong>Reduction Vouchers for you</strong>
        </div>
        <div id="event-container" class="px-0 card-body">

        </div>
      </div>
    </div>
  @endif
</div>
@stop
@section('foot_script')
<script>
  var postId = $("#post_id").val();
  var userAuthId = $("#user_auth_id").val();
  var canUpdate = $("#can_update").val();
  var status = $("input[name='status']:checked").val();
  var eventTotal = $("#events").val();
  
  function resetEditable() {
    if(userAuthId && canUpdate) {
      $.ajax({
          url: `/home/editable-post?post_id=${postId}`, 
          type: 'GET',
        });
    }
  };
  
  $(window).on('beforeunload', ()=> resetEditable());

  function _timer(callback) {
    var time = 0;
    var state = 0;
    var timer_id;
    
    this.start = function(interval) {
      interval = (typeof(interval) !== 'undefined') ? interval : 1000;
      if(state == 0) {
        state = 1;
        timer_id = setInterval(function(){
          if(time) {
            time--;
            if(typeof(callback) === 'function') {
              callback(time);
            }
          }
        }, interval);
      }
    };

    this.stop = function(){
      if(state == 1){
        state = 0;
        clearInterval(timer_id);
      }
    };
    
    this.reset = function(sec) {
      sec = (typeof(sec) !== 'undefined') ? sec : 0;
      time = sec;
    };
  };
  

  $(document).ready(function(){

    if(postId && userAuthId && !canUpdate && status !== 'draft') {
      
      $.ajax({
      url: `/home/reader-tracking?post_id=${postId}`,
      type: 'GET',
      });
    }
    
    if(userAuthId && canUpdate) {
      $.ajax({
        url: `/home/posts-being-edited?post_id=${postId}`, 
        type: 'GET',
      });
      
      handelEditablePost();
    }
     
    $("#submit_button").click(function(event) {
      event.preventDefault();
      let isError = false;

      let categoryId = $("#category_id").val();
      let title = $("#post_title").val();
      let status = $("input[name='status']:checked").val();
      let content = $("#post_content").val();

      if(!categoryId) {
        isError = true;
        toastr.warning('Warning', 'The category is required!');
      }
      if(isError) return 0;

      if(!title) {
        isError = true;
        toastr.warning('Warning', 'The title is required!');
      }
      if(isError) return 0;

      if(!status) {
        isError = true;
        toastr.warning('Warning', 'The status is required!');
      }
      if(isError) return 0;

      if(!content) {
        isError = true;
        toastr.warning('Warning', 'The content is required!');
      }
      if(isError) return 0;

      if(!isError) {
       $("#postsForm").submit();
      }      
    });

    getVouchers();
  });
  
  function handelEditablePost() {
    
    var timer = new _timer(function(time) {
      if(time == 0) {
        toastr.warning('Warning', 'You do not anthing in 5 minute, The post can be edited by an others!');
        resetEditable();
      }
    });
    
    timer.reset(300);
    timer.start(1000);

    $("#post_content").keyup(function(){
      timer.reset(300);
    });
  };
  
  function getVouchers() {
    if(userAuthId && eventTotal) {
      let callback = function(paramObject, idx) {
        let {maxNum} = paramObject;
        return {
          type: 'GET',
          url: `/home/event-partial?page=${idx + 1}&paginate=1`,
          success: function(data) {
            if(data) {
              $("#event-container").append(data);
              if(idx == maxNum-1) {
                handelGetVoucher();
              }
            }
          }
        };
      };
      let paramObject = {
        maxNum: eventTotal
      };
      sendAjax(callback, paramObject);
    }
  };

  function handelGetVoucher() {
    $(".get_voucher_button").click(function(){
      let voucherId = $(this).data("voucher_id");
      $.ajax({
        type: 'GET',
        url: `/home/get-voucher-for-user?voucher_id=${voucherId}`
      }).done(function(data){
        // console.log(data);
        if(data.success) {
          let button = $(`[data-voucher_id="${voucherId}"]`);
          button.attr("disabled", true);
          button.removeClass("btn-primary");
          button.addClass("btn-secondary");
          toastr.success(data.message);
        } else {
          toastr.warning(data.message, data.message_title);
        }
      });
    });
  };

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