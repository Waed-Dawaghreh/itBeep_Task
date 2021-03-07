@extends("layouts.app")
@section("content")
<div class="row d-flex justify-content-center">
  <div class="col-lg-5 form_container">
    <form id="services_form" onsubmit="event.preventDefault()">
      {{csrf_field()}}
      <div class="modal-header">
        <p style="margin: auto; font-size:70px"> ItBeep </p>
      </div>
      <div class="form-group">
        <label>الإسم</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>
      <div class="form-group">
        <label>الهاتف</label>
        <input type="number" class="form-control " id="number" name="number">
      </div>
      <div class="form-group">
        <label>البريد الإلكتروني</label>
        <input type="email" class="form-control" id="email" name="email">
      </div>
      <input type="hidden" id="service" name="service">
      <input type="hidden" id="interest" name="interest">

      <button type="button" class="btn btn-block" data-toggle="modal" data-target="#exampleModalCenter">
        إرسال
      </button>

      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="d-flex justify-content-between">
                @foreach($services as $service)
                <button class="btn" name="services" style="border:none; width:32%" onclick="setServices('{{$service->name}}',event)">
                  {{$service->name}}
                </button>
                @endforeach
              </div>
              <button type="button" class="btn btn-block mt-1" data-toggle="modal" data-target="#exampleModalCenter2" id="firstModalButton" onclick="nextButton()">التالي</button>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" data-dismiss="modal">إغلاق</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body d-flex justify-content-between">
              @foreach($interests as $interest)
              <button class="btn" name="interests" style="border: none; width:32%" onclick="setInterests('{{$interest->name}}',event)">
                {{$interest->name}}
              </button>
              @endforeach
            </div>
            <div class="modal-footer">
              <button type="button" class="btn" data-dismiss="modal">إغلاق</button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section("scripts")
<script>
  $("#firstModalButton").click(e => {
    e.preventDefault();
    $('#exampleModalCenter').modal('hide')
  });

  var services = [];

  function setServices(name, event) {
    if (event.target.style.border == "none") {
      event.target.style.border = "solid 3px green";
      services.push(name);
    } else {
      event.target.style.border = "none";
      services.splice(services.indexOf(name), 1);
    }
  }

  function setInterests(name, event) {
    $("#interest").val(name);
    $.ajax({
      url: '{{ url("/addToSession") }}',
      method: "POST",
      contentType: false,
      cache: false,
      processData: false,
      data: new FormData($("#services_form").get(0)),
      success: function(response) {
        console.log(response);
      }
    });
  }


  function nextButton() {
    $("#service").val(services);
  }
</script>
@endsection