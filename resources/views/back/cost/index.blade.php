@extends('back.layouts.app2')

@section('title') الطلاب @endsection


@section('header')
    <link href="{{ url('back') }}/assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection

@section('footer')
    <script src="{{ url('back') }}/assets/plugins/select2/js/select2.min.js"></script>
    <script src="{{ url('back') }}/assets/js/select2.js"></script>
    

    @include('back.cost.get_mats_after_change_year')
    @include('back.cost.add_new_row_form')
    @include('back.cost.add_mat_to_table')
    
@endsection

@section('content')

    <div class="main_div_1">
        <h5 class="text-center" style="width: 90%;margin: 10px auto;background-color: #757fb5;padding: 20px; line-height: 30px;color: #fff;">
            هذا النموذج يمكنك من معرفة القيمة التقريبية إلشتراكك 
            الشهري بأكاديمية إديوستيدج بناء على قائمة أسعار الباقات 
            المختلفة وشروط تطبيق الخصومات 
        </h5>

        <br>
        <div>
            <form>
                @csrf
                <div class="d-flex" style="margin: 30px auto 20px;">
                    <span class="avatar avatar-sm brround bg-warning">1</span>
                    <span class="mg-r-10 mg-t-7">
                </div>

                <div class="sections_count main_div_form_1" main_div_id="1" style="background: #EEEEEE;padding: 20px;border-radius: 5px;position: relative;margin: 10px auto;">
                    <div id="the_year_div_1">
                        <div class="row">
                            <div class="col-md-3" >
                                <label for="TheYear">الصفوف الدراسيه</label>
                                <select class="form-control TheYear TheYear_1" id="TheYear" the_year_length_attr="1" name="TheYear" style="width: 100%;">
                                    <option value="---">---</option>
                                    @foreach ($the_years as $item)
                                        <option value="{{ $item->TheYear }}">{{ $item->TheYear }}</option>
                                    @endforeach
                                </select>
                                <p class="errors" id="errors-TheYear"></p>
                            </div>
                        
                            <div class="col-md-3" >
                                <label for="TheMats">المواد الدراسيه</label>
                                <select class="form-control TheMats TheMats_1" id="TheMats_1" the_mats_length_attr="1" name="TheMats" style="width: 100%;">
                                    <option value="---">---</option>
                                </select>
                                <p class="errors" id="errors-TheMats"></p>
                            </div>

                            <div class="col-md-2">
                                <label for="">اضف صف</label>        
                                <button class="btn btn-primary" style="display: block;background-color: #757fb5;" id="add_new">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <br>
    
                    <div id="the_year_table_1">
                        <table class="table table-bordered" table_length_attr="1">
                            <thead class="thead-dark">
                                <tr>
                                    <th>الماده حسب الصف</th>
                                    <th>نوع الباقه</th>
                                    <th>ثمن الحصه</th>
                                    <th>عدد الحصص</th>
                                    <th>مجموع قبل</th>
                                    <th>خصم</th>
                                    <th>مجموع بعد</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        
        <br><br><hr><br><br><br>
        <div id="the_year_div_cost_1" style="float: left;background: #757fb5;padding: 15px 80px;font-weight: bold;color: #fff;">
            <p>اجمالي مبلغ الفاتوره قبل الخصم : <span style="color: #222;font-weight: bold;font-size: 17px;">100 ج.م</span></p>
            <p>اجمالي مبلغ الفاتوره بعد الخصم : <span style="color: #222;font-weight: bold;font-size: 17px;">80 ج.م</span></p>
            {{-- <p>نسبه الخصم : <span style="color: red;font-weight: bold;font-size: 17px;">20 ج.م</span></p> --}}
        </div>
    </div>
    

@endsection