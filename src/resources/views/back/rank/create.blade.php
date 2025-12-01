 @extends('layouts.template')
 @section('content')
  

 <section id="Nearmiss" class="Nearmiss">
     <div class="container">

         <div class="row justify-content-center">
             <div class="col-lg-10 align-items-center">


                 <div class="title-box">
                     <img src="img/Logo-Business-BGC.png" alt="" class="img-fluid">
                     <div class="Nearmiss-title">
                         <p>เพิ่มข้อมูลความเสี่ยง</p>
                     </div>
                 </div>
                 <form action="{{ route('rank.store') }}" method="POST">
                    @csrf
                     <div class="box-user">
                         <div class="form-group">
                             <label for="dataEmpName">ระดับความรุนแรง : </label>
                             <input type="text" class="form-control" id="rank" name="rank"  value="">
                                @error('rank')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                         </div>
                     </div>


                

                     <hr>
                     <div class="box-user  col-9">
                        <div class="form-group">
                            <label for="rank_mening">ความหมาย : </label>
                            <input type="text" class="form-control" id="rank_mening" name="rank_mening" value="">
                               @error('rank_mening')
                                   <span class="text-danger">{{ $message }}</span>
                               @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="box-user  col-9">
                        <div class="form-group">
                            <label for="rank_action">แนวทางการแก้ไข : </label>
                            <input type="text" class="form-control" id="rank_action" name="rank_action" value="">
                               @error('rank_mening')
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

 