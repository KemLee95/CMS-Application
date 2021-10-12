@if (isset($vouchers) && $vouchers)
  @foreach ($vouchers as $index => $voucher)
  <tr id="voucher_{{isset($page) && $page ? $page : ""}}"  class="voucher_partial">
    <th scope="row">
      <strong class="index">{{isset($page) && $page ? $page : ""}}/</strong>
      <input type="hidden" name="voucher_id[]" value="{{isset($voucher->id) && $voucher->id ? $voucher->id : ""}}">
    </th>
    <td>
      <input class="form-control percentage_decrease" type="number" name="percentage_decrease[]" min="0" max="100" step="1"
        {{isset($voucher->users) && $voucher->users ? "disabled":""}}
        value="{{isset($voucher->percentage_decrease)&&$voucher->percentage_decrease ? $voucher->percentage_decrease : ""}}"
      >
    </td>
    <td>
      <input class="form-control maximum_quantity" type="number" name="maximum_quantity[]"
        min="{{
          (isset($voucher->maximum_quantity)&&$voucher->maximum_quantity ? $voucher->maximum_quantity : 0) -
          (isset($voucher->available_quantity)&&$voucher->available_quantity ? $voucher->available_quantity : 0)
        }}"
        value="{{isset($voucher->maximum_quantity)&&$voucher->maximum_quantity ? $voucher->maximum_quantity : ""}}"
      >
    </td>
    <td>
      <input class="form-control expiry_date" type="date" name="expiry_date[]"
        value="{{isset($voucher->expiry_date)&&$voucher->expiry_date ? date('Y-m-d', strtotime($voucher->expiry_date)) : ""}}"
      >
    </td>
    <td class="d-flex">
      <button type="button" class="btn btn-danger delete_button"
        {{isset($voucher->users) && $voucher->users ? "disabled":""}}
        data-voucher_index={{isset($page) && $page ? $page : ""}}
      >X</button>
      <a href="/admin/voucher/{{isset($voucher->id) && $voucher->id ? $voucher->id : ""}}" class="ml-2 btn btn-info">Go more</a>
    </td>
  </tr>
  @endforeach
@else
  <tr id="voucher_{{isset($index) && $index ? $index : ""}}" class="voucher_partial">
    <th scope="row">
      <strong class="index">{{isset($index) && $index ? $index : ""}}/</strong>
    </th>
    <td><input class="form-control percentage_decrease" type="number" name="percentage_decrease[]" min="0" max="100" step="1"></td>
    <td><input class="form-control maximum_quantity" type="number" name="maximum_quantity[]"></td>
    <td><input class="form-control expiry_date" type="date" name="expiry_date[]"></td>
    <td>
      <button type="button" class="btn btn-danger delete_button"
      data-voucher_index={{isset($index) && $index ? $index : ""}}>X</button>
    </td>
  </tr>
@endif