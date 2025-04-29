<div class="modal fade" id="pollsQuestionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form>
                @csrf

                <input type="hidden" name="res_id" id="res_id" value="">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">                    
                    <div class="modal-body">
                        <div class="pd-30 pd-sm-40 bg-gray-100">
                            <div class="row row-xs">
                                <div class="col-md-12">
                                    <label for="question">السؤال</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                                        </div>
                                        {{-- <input class="form-control" id="question" name="question" placeholder="السؤال" type="text" value="" /> --}}
                                        <textarea class="form-control" id="question" name="question" placeholder="السؤال" type="text" rows="5"></textarea>
                                    </div>
                                    <p class="errors" id="errors-question"></p>
                                </div>
                                
                                <div class="col-md-9">
                                    <label for="group">مجموعات الإستبيان</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-poll"></i></span>
                                        </div>
                                        <select class="form-control" name="group" id="group">
                                            <option value="">---</option>
                                            @foreach ($polls_group as $group)                                                
                                                <option value="{{ $group->id }}">{{ $group->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="errors" id="errors-group"></p>
                                </div>
                                
                                <div class="col-md-3">
                                    <label for="percentage">نسبة مئوية %</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-percent"></i></span>
                                        </div>
                                        <input class="form-control" id="percentage" name="percentage" placeholder="نسبة مئوية %" type="number" value="" />
                                    </div>
                                    <p class="errors" id="errors-percentage"></p>
                                </div>
                                                
                                <div class="col-md-6">
                                    <label for="type">نوع السؤال</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-check"></i></span>
                                        </div>
                                        <select class="form-control" name="type" id="type">
                                            <option value="">---</option>
                                            {{-- <option value="checkbox">اختيار من متعدد</option> --}}
                                            <option value="radio" selected>اختيار إجابة واحدة</option>
                                            <option value="textarea">سؤال مقالي</option>
                                            <option value="date">تاريخ</option>
                                        </select>
                                    </div>
                                    <p class="errors" id="errors-type"></p>
                                </div>
                                                
                                <div class="col-md-6">
                                    <label for="status">حالة السؤال</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-check"></i></span>
                                        </div>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1">نشط</option>
                                            <option value="0">غير نشط</option>
                                        </select>
                                    </div>
                                    <p class="errors" id="errors-status"></p>
                                </div>
                            </div>
                        </div>
                    </div>                                                                  
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary save" style="display: none;">حفظ</button>
                    <button type="submit" class="btn btn-success update" style="display: none;">تعديل</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">إلغاء</button>
                </div>
            </form>  
        </div>
    </div>
</div>