<div class="ibox">
    <div class="ibox-body">
        <div class="row">
            <div class="col-md-6">
                <form action="">
                    @csrf
                    <div class="modal-body mx-3">
                        <div class="form-group">
                            <label for="" class="required">Amount</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend bg-light p-2 border">
                                    <div class="input-group-text">{{ price_unit() }}</div>
                                </div>
                                <input type="number" name="amount" class="form-control" required="" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" name="created_at" class="form-control">
                            <small>Leave empty for current date</small>
                        </div>
                        <div class="form-group">
                            <label for="" class="required">Transaction Remarks</label>
                            <textarea type="text" name="remarks" class="form-control" required></textarea>
                            <small class="form-text">Type in transaction date, E-sewa or bank transaction number.</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Deposit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
