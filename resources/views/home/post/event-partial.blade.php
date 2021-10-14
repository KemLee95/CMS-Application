@if (isset($events) && $events)
  @foreach ($events as $event)
    <div class="card-header">
      <label class="form-label" for="Event">
        <strong class="text-capitalize text-danger">
          {{isset($event->name) && $event->name ? $event->name : ""}}
        </strong>
      </label>
    </div>

    <div class="flex-wrap p-1 card-body d-flex">
      @if (isset($event->vouchers) && $event->vouchers)          
        @foreach (($event->vouchers) as $voucher)
            <button class="m-1 btn {{$voucher->isExist || !($voucher->available_quantity) ? "btn-secondary" : "btn-primary"}} get_voucher_button" style="width: fit-content"
              {{$voucher->isExist || !($voucher->available_quantity) ? "disabled" : ""}}
              data-voucher_id="{{isset($voucher->id) && $voucher->id ? $voucher->id : "" }}"
            >
              <strong>
                {{isset($voucher->available_quantity) ? $voucher->available_quantity : 0}} / {{isset($voucher->maximum_quantity) ? $voucher->maximum_quantity : 0}}
              </strong>
              Reduce {{isset($voucher->percentage_decrease) && $voucher->percentage_decrease ? $voucher->percentage_decrease : "" }}%
            </button>
        @endforeach
      @endif
    </div>
  @endforeach
@endif
