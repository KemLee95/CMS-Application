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

<div class="row justify-content-center">
    <div class="border-black border-solid col-8 card border-radius magrin-bt">
      <form id="postsForm" action="save-post" method="POST">
        {{ csrf_field() }}
        <input id="post_id" type="hidden" name="id" value={{isset($post)&& $post->id ? $post->id : ""}}>
        <input id="user_auth_id" type="hidden" value={{isset($user_auth)&& $user_auth->id ? $user_auth->id : ""}}>
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
                <textarea class="form-control" id="post_content" name="title" rows="2">
                  {{isset($post->title) && $post->title ? $post->title :""}}
                </textarea>
              </h5>
            </div>
            <div class="col-12 text-nowrap text-truncate text-capitalize">
              <div class="d-flex align-items-center justify-content-between">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-secondary 
                    {{isset($post->status) && $post->status === "published" ? "active":""}} "
                  >
                    <input type="radio" value="published" name="status" id="option1" autocomplete="off" {{isset($post->status) && $post->status === 'published' ? "checked":""}}>
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                        <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                      </svg>
                    </span>
                  </label>
                  <label class="btn btn-secondary 
                    {{isset($post->status) && $post->status == 'unpublished' ? "active":""}}"
                  >
                    <input type="radio" value="unpublished" name="status" id="option3" autocomplete="off" {{isset($post->status) && $post->status === 'unpublished' ? "checked":""}}>
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                      </svg>
                    </span>
                  </label>
                </div>
                <div >
                  @if (isset($post) && $post)
                    <strong>{{isset($post->user_name) && $post->user_name ? $post->user_name :""}}</strong>            
                    <span class="p-1 border-radius btn-info">{{ isset($post->updated_at) && $post->updated_at ?  date('d/m/Y', strtotime($post->updated_at)) : "" }}</span>
                  @endif
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label for="content">
              <strong>Content</strong>
            </label>
            <textarea class="form-control" id="post_content" name="content" rows="10">
              {{isset($post->content) && $post->content ? $post->content :""}}
            </textarea>
          </div>
        </div>
        <div class="card-body">
          @if (isset($user_auth) && $user_auth)
            @if (isset($isUpdate) && $isUpdate)
            <button id="submit-button" type="btn" class="btn w-100 btn-success" 
              {{isset($user_auth->isAdmin) && $user_auth->isAdmin || isset($user_auth->isAdmin) && $user_auth->id === $post->user_id ? "":"disabled" }}
            >Submit</button>
            @else
              <button id="submit-button" type="btn" class="btn w-100 btn-success">Submit</button>
            @endif
          @endif
        </div>
      </form>
    </div>
</div>

@stop
@section('foot_script')
<script>
  $(document).ready(function(){
    let postId = $("#post_id").val();
    let userAuthId = $("#user_auth_id").val();
    
    if(postId && userAuthId) {
      $.ajax({
      url: `/home/reader-tracking?post_id=${postId}`,
      type: 'GET',
      }).done(function(data){
      });
    };
     
    $("#submit_button").click(function(event) {
      event.preventDefault();
      let title = $("#post_title").val();
      let content = $("#post_content").val();

      $("#postsForm").submit();
    })
  });
</script>
@stop