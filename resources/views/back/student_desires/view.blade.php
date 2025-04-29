<div class="modal-body" style="padding: 60px 20px;">
    <div class="row">
        <div class="col-md-4 text-center" style="margin-bottom: 50px;">
            <h4 class="text-center">معلومات الطالب</h4>     
            <br>                   
            <div id="total_items">
                <bold>اسم الطالب</bold>
                : <span style="color:red;font-size: 15px;margin: 0px 10px;">{{ $student->student_name['TheName'] }}</span>
            </div>
            
            <hr/>
            
            <div id="total_app.total_money">
                <bold>اسم ولي الأمر</bold>
                : <span style="color:red;font-size: 15px;margin: 0px 10px;">{{ $user_name }}</span>
            </div>
            
            <hr/>
            
            <div id="notices">
                <bold>الصف الدراسي</bold>
                : <span style="color:red;margin: 0px 10px;">{{ $year['TheYear'] }}</span>
            </div>
        </div>
            
        <div class="col-md-8" id="content">
            <h4 class="text-center">رغبات الطالب</h4>
            <br>        
            <table class="table text-center table-reponsive table-striped table-bordered">  
                <thead>
                    <tr>
                        <th style="font-weight: bold;color: #000;text-decoration: underline;">الماده</th>    
                        <th style="font-weight: bold;color: #000;text-decoration: underline;">الفتره</th>    
                        <th style="font-weight: bold;color: #000;text-decoration: underline;">الباقه</th>    
                        <th style="font-weight: bold;color: #000;text-decoration: underline;">ملاحظات</th>    
                    </tr>    
                </thead>              
                <tbody>
                    @foreach ($mats as $item)
                       <tr>
                           <td style="font-size: 15px;">{{ $item->mats_name['TheMat'] }}</td>
                           <td style="font-size: 15px;">
                                @if ($item->time == 1)
                                    صباحا
                                @else
                                     مساء
                                @endif
                            </td>
                           <td style="font-size: 15px;">
                                @if ($item->package == 1)
                                    باقه 1 طالب  
                                @elseif($item->package == 2)
                                    باقه 2 طالب 
                                @elseif($item->package == 3)
                                     باقه 3-6 طالب
                                @elseif($item->package == 4)
                                    باقه التوفير
                                @endif
                            </td>
                            <td style="font-size: 15px;">{{ $item->notes }}</td>
                        </tr>        
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    {{-- <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">{{trans('app.Close')}}</button>
    <a href="{{ url('admin/expenses/print/'.$find['group_id']) }}" type="button" class="btn btn-primary waves-effect waves-light" id="save">{{trans('app.Print')}}</a> --}}
</div>

<script>
    $(".modal-title").text("عرض رغبات الطالب");
</script>