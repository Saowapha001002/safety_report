 @extends('layouts.template')
 @section('content')
  

 <section id="Nearmiss" class="Nearmiss">
     <div class="container">

         <div class="row justify-content-center">
             <div class="col-lg-10 align-items-center">


                 <div class="title-box">
                     <img src="img/Logo-Business-BGC.png" alt="" class="img-fluid">
                     <div class="Nearmiss-title">
                         <p>เพิ่ม สภาพการณ์</p>
                     </div>
                 </div>
                 <form action="{{ route('cause.store') }}" method="POST">
                    @csrf
                     <div class="box-user">
                         <div class="form-group">
                             <label for="dataEmpName">สภาพการณ์ : </label>
                             <input type="text" class="form-control" id="cause" name="cause"  value="">
                                @error('cause')
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

 