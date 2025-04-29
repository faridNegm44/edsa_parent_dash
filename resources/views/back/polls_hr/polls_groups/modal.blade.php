<div class="modal fade" id="pollsGroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="col-md-6">
                                    <label for="title">عنوان المجموعة</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-pen"></i></span>
                                        </div>
                                        <input class="form-control" id="title" name="title" placeholder="عنوان المجموعة" type="text" value="" />
                                    </div>
                                    <p class="errors" id="errors-title"></p>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="status">حالة المجموعة</label>
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
                                                
                                <div class="col-md-6">
                                    <label for="from">من</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                        </div>
                                        <input class="form-control" id="from" name="from" placeholder="من" type="datetime-local">
                                    </div>
                                    <p class="errors" id="errors-from"></p>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="to">الي</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                        </div>
                                        <input class="form-control" id="to" name="to" placeholder="من" type="datetime-local">
                                    </div>
                                    <p class="errors" id="errors-to"></p>
                                </div>
                                                                    
                                
                                <div class="col-md-12">
                                    <label for="special">تخصيص المجموعة</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-check"></i></span>
                                        </div>
                                        <select class="form-control" name="special" id="special">
                                            <option value="">---</option>
                                            <option value="hr">الإدارة</option>
                                            <option value="teachers">المدرسين</option>
                                        </select>
                                    </div>
                                    <p class="errors" id="errors-special"></p>
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