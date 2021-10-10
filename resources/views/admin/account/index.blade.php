@extends('admin.master')
@section('head_style')
    <style>
        .stories-card__title, .stories-card .card-title, .stories-card .card-title > a {
            max-width: 350px;
        }
    </style>
@stop
@section('content')

<div class="row justify-content-center">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">STT</th>
            <th scope="col">User name</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Verified</th>
            <th scope="col">Created at</th>
            <th scope="col"> </th>
          </tr>
        </thead>
        <tbody>
            @if (isset($accounts) && $accounts)
            @foreach ($accounts as $index => $account)
                <tr>
                    <th scope="row">
                        @if (isset($startCount))
                            {{$startCount + $index}}
                        @endif
                    </th>
                    <td>
                        <a href="{{Request::url()}}/{{isset($account->id) && $account->id ? $account->id : ""}}">
                            {{isset($account->user_name) && $account->user_name ? $account->user_name : ""}}
                        </a>
                    </td>
                    <td>
                        {{isset($account->name) && $account->name ? $account->name : ""}}
                    </td>
                    <td>
                        {{isset($account->email) && $account->email ? $account->email : ""}}
                    </td>
                    <td>
                        {{isset($account->email_verified_at) && $account->email_verified_at ? date('d/m/Y', strtotime($account->email_verified_at)) : "Not yet verified"}}
                    </td>
                    <td>
                        {{isset($account->created_at) && $account->created_at ? date('d/m/Y', strtotime($account->created_at)): ""}}
                    </td>
                    <td>
                        <button class="ml-2 btn btn-danger deleteButton" data-toggle="modal" data-target="#exampleModal"
                         {{(isset($account->state) && $account->state == 'disabled')  ? "disabled":""}}
                            data-user_id={{isset($account->id) && $account->id ? $account->id : ""}}
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                          </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            @endif
    </table>
    <form id="deleteForm" method="POST" action="delete-account">
        {{ csrf_field() }}
        <input id="user_id" type="hidden" name="user_id" value="">
    </form>
    @if (isset($pagination) && $pagination )
    <div class="paginate-item">
        {{ isset($pagination) && $pagination ? $pagination->links() : '' }}
    </div>
    @endif
</div>
@stop
<section>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete Account</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="submitButton" type="button" class="btn btn-primary">Delete</button>
            </div>
          </div>
        </div>
      </div>
</section>
@section('foot_script')
<script>
    $(document).ready(function(){

        $(".deleteButton").click(function(){
            let userId = $(this).data("user_id");
            $("#submitButton").click(function(){
                $("#user_id").val(userId);
                $("#deleteForm").submit();
            })
        });
            

    });
</script>
@stop