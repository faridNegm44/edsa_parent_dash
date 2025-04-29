<script>
    $("#add_new").click(function(e){
        e.preventDefault();
        var length = $(".length").length+1;
        let sections_count = $('.sections_count').length+1;

        $("form").append(`
            <div class="d-flex" style="margin: 30px auto 20px;">
                <span class="avatar avatar-sm brround bg-warning">`+sections_count+`</span>
                <span class="mg-r-10 mg-t-7">
            </div>
            
            <div class="sections_count main_div_form_`+sections_count+`" main_div_id="`+sections_count+`" style="background: #EEEEEE;padding: 20px;border-radius: 5px;margin: 10px auto;">
                <div id="the_year_div_`+sections_count+`">
                    <div class="row">
                        <div class="col-sm-3" >
                            <label for="TheYear">الصفوف الدراسيه</label>
                            <select class="form-control TheYear TheYear_`+sections_count+`" id="TheYear_`+sections_count+`"the_year_length_attr="1" name="TheYear" style="width: 100%;">
                                <option value="---">---</option>
                                @foreach ($the_years as $item)
                                    <option value="{{ $item->TheYear }}">{{ $item->TheYear }}</option>
                                @endforeach
                            </select>
                            <p class="errors" id="errors-TheYear"></p>
                        </div>
                    
                        <div class="col-sm-3" >
                            <label for="TheMats">المواد الدراسيه</label>
                            <select class="form-control TheMats TheMats_`+sections_count+`" id="TheMats_`+sections_count+`"the_mats_length_attr="1" name="TheMats" style="width: 100%;">
                                <option value="---">---</option>
                            </select>
                            <p class="errors" id="errors-TheMats"></p>
                        </div>
                    </div>
                </div>

                <br>    
                <div id="the_year_table_`+sections_count+`">
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
        `);
    });
</script>