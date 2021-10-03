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
</style>
@stop
@section('content')
<div class="row justify-content-center">
  <div>
    <a class="btn btn-success" href="{{Request::url()}}">Manage Posts</a>
    <a class="btn btn-info" href="{{Request::url()}}/accounts">Manage CMS Accounts</a>
  </div>
  @if (isset($posts) && $posts)
    <div class="categories row justify-content-between align-items-center container-fluid">
      <div class="col-4 form-group">
        <div>
          <label for="categories">
            <strong>
              Categories
            </strong>
          </label>
        </div>
        <form action="{{Request::url()}}">
          <div class="d-inline-flex">
            <select class="form-control" id="category_id" style="width: 100%" name="category_id">
              <option value="">Select the category</option>
              @if (isset($categories) && $categories)
                  @foreach ($categories as $category)
                      <option {{isset($filterData["category_id"]) && ($filterData["category_id"] == $category->id) ? "selected":"" }} value="{{isset($category->id) && $category->id ? $category->id :""}}">{{isset($category->name) && $category->name ? $category->name :""}}</option>
                  @endforeach
              @endif
            </select>
            <button type="submit" class="ml-2 btn btn-info">Search</button>
          </div>
        </form>
      </div>
      <div>
        <a class="btn btn-success" href="{{Request::url()}}/post/new">Create New Post</a>
      </div>
    </div>
    <div class="container-fluid">
      @foreach ($posts as $post)
        <div class="bg-black border-black border-solid card border-radius magrin-bt">
          <div class="card-header">
            <div class="row">
              <div class="col-8 text-nowrap text-truncate text-capitalize">
                <h5>
                  {{isset($post->title) && $post->title ? $post->title :""}}
                </h5>
              </div>
              <div class="col-4">
                <div class="row">
                  <div class="col-8">
                    <div>
                      <div>
                        <strong>{{isset($post->user_name) && $post->user_name ? $post->user_name :""}}</strong>
                      </div>
                      <div class="w-100">
                        <span class="p-1 btn-info">{{ isset($post->created_at) && $post->created_at ?  date('d/m/Y', strtotime($post->created_at)) : "" }}</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="d-inline-flex">
                      @if (isset($post->status) && $post->status === 'published')
                        <button class="btn btn-success">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                            <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855A7.97 7.97 0 0 0 5.145 4H7.5V1.077zM4.09 4a9.267 9.267 0 0 1 .64-1.539 6.7 6.7 0 0 1 .597-.933A7.025 7.025 0 0 0 2.255 4H4.09zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a6.958 6.958 0 0 0-.656 2.5h2.49zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5H4.847zM8.5 5v2.5h2.99a12.495 12.495 0 0 0-.337-2.5H8.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5H4.51zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5H8.5zM5.145 12c.138.386.295.744.468 1.068.552 1.035 1.218 1.65 1.887 1.855V12H5.145zm.182 2.472a6.696 6.696 0 0 1-.597-.933A9.268 9.268 0 0 1 4.09 12H2.255a7.024 7.024 0 0 0 3.072 2.472zM3.82 11a13.652 13.652 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5H3.82zm6.853 3.472A7.024 7.024 0 0 0 13.745 12H11.91a9.27 9.27 0 0 1-.64 1.539 6.688 6.688 0 0 1-.597.933zM8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855.173-.324.33-.682.468-1.068H8.5zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.65 13.65 0 0 1-.312 2.5zm2.802-3.5a6.959 6.959 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5h2.49zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7.024 7.024 0 0 0-3.072-2.472c.218.284.418.598.597.933zM10.855 4a7.966 7.966 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4h2.355z"/>
                          </svg>
                        </button>
                      @elseif(isset($post->status) && $post->status === 'draft'))
                        <button class="btn btn-warning">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                          </svg>
                        </i></button>
                      @else
                        <button class="btn btn-secondary">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                          </svg>
                        </button>
                      @endif
                      <button class="ml-2 deletePostButton btn btn-danger" {{(isset($user_auth->isAdmin) && $user_auth->isAdmin==true) || (isset($post->user_id) && $post->user_id == $user_auth->id) ? "":"disabled"}}
                          data-post_id={{isset($post->id) && $post->id ? $post->id:""}}
                      >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                      </button>
                    </div>
                    <div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <p class="card-text">{{isset($post->content) && $post->content ? $post->content :""}}</p>
            <a href="{{Request::url()}}/post/{{$post->id}}" class="btn btn-primary">Go More</a>
          </div>
        </div>
      @endforeach
    </div>
    <form id="deleteForm" action="{{Request::url()}}/post/delete-post" method="POST">
      {{ csrf_field() }}
      <input id="deleted_post_id" type="hidden" value="">
    </form>
  @endif
  @if (isset($pagination) && $pagination )
    <div class="paginate-item">
      {{ isset($pagination) && $pagination ? $pagination->links() : '' }}
    </div>
  @endif
</div>
@stop
@section('foot_script')
<script>
  $(document).ready(function(){
    $(".deletePostButton").click(function(){
      let postId = $(this).data('post_id');
      $("#deleted_post_id").val(postId);
      
      if(postId) {
        $("#deleteForm").submit();
      }
    })
  });
</script>
@stop