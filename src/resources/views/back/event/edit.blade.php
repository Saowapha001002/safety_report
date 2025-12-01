@extends('layouts.template')
@section('content')
<section id="Nearmiss" class="Nearmiss">
     <div class="container">

         <div class="row justify-content-center">
             <div class="col-lg-12 align-items-center">


                 <div class="title-box">
                     <img src="img/Logo-Business-BGC.png" alt="" class="img-fluid">
                     <div class="Nearmiss-title">
                         <p></p>
                     </div>
                 </div>
                 <form action="{{ route('event.update',$event->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                     <div class="box-user">
                         <div class="form-group  col-3">
                             <label for="event">เหตุการณ์ : </label>
                             <input type="text" class="form-control" id="event" name="event" value="{{ $event->event }}">
                                @error('event')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                         </div>
                         
                     </div>
                     <hr>
                     <div class="box-user  col-9">
                        <div class="form-group">
                            <label for="event_note">เหตุการณ์ที่พบ : </label>
                            <input type="text" class="form-control" id="event_note" name="event_note" value="{{ $event->event_note }}">
                               @error('event_note')
                                   <span class="text-danger">{{ $message }}</span>
                               @enderror
                        </div>
                    </div>
                    <hr>
                    
                   
                     <button type="submit" class="btn btn-primary">Save</button>
                 </form>
             </div>
         </div>

     </div>
 </section><!-- End Why Us Section -->
@endsection