    <div class="form-group">
        <label>IP یا دامنه</label>
        <input type="text" dir="ltr" value="{{ old('server',$product->options['server']) }}" class="form-control{{ $errors->has('server') ? ' is-invalid' : '' }}" name="server">
    </div>
<div class="form-group">
    <label>نام کاربری</label>
    <input type="text" dir="ltr" value="{{ old('username',$product->options['username']) }}" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username">
</div>
<div class="form-group">
    <label>API Token</label>
    <input type="text" dir="ltr" value="{{ old('token',$product->options['token']) }}" class="form-control{{ $errors->has('token') ? ' is-invalid' : '' }}" name="token">
</div>
    <div class="form-group">
        <label>نام بسته جدید</label>
        <input type="text" dir="ltr" value="{{ old('plan',$product->options['plan']) }}" class="form-control{{ $errors->has('plan') ? ' is-invalid' : '' }}" name="plan">
    </div>
    <div class="form-group">
        <label>نام بسته فعلی</label>
        <input type="text" dir="ltr" value="{{ old('pkgname',$product->options['pkgname']) }}" class="form-control{{ $errors->has('pkgname') ? ' is-invalid' : '' }}" name="pkgname">
    </div>
    <div class="form-group">
        <label>ذخیره بسته</label>
        <input type="text" dir="ltr" value="{{ old('savepkg',$product->options['savepkg']) }}" class="form-control{{ $errors->has('savepkg') ? ' is-invalid' : '' }}" name="savepkg">
    </div>
    <div class="form-group">
        <label>نمایندگی</label>
        <input type="text" dir="ltr" value="{{ old('reseller',$product->options['reseller']) }}" class="form-control{{ $errors->has('reseller') ? ' is-invalid' : '' }}" name="reseller">
    </div>

<div class="form-group">
    <label>فضا</label>
    <input type="text" dir="ltr" value="{{ old('quota',$product->options['quota']) }}" class="form-control{{ $errors->has('quota') ? ' is-invalid' : '' }}" name="quota">
</div>
<div class="form-group">
    <label>پهنای باند</label>
    <input type="text" dir="ltr" value="{{ old('bwlimit',$product->options['bwlimit']) }}" class="form-control{{ $errors->has('bwlimit') ? ' is-invalid' : '' }}" name="bwlimit">
</div>
<div class="form-group">
    <label>تعداد FTP</label>
    <input type="text" dir="ltr" value="{{ old('maxftp',$product->options['maxftp']) }}" class="form-control{{ $errors->has('maxftp') ? ' is-invalid' : '' }}" name="maxftp">
</div>
<div class="form-group">
    <label>تعداد SQL</label>
    <input type="text" dir="ltr" value="{{ old('maxsql',$product->options['maxsql']) }}" class="form-control{{ $errors->has('maxsql') ? ' is-invalid' : '' }}" name="maxsql">
</div>
<div class="form-group">
    <label>تعداد POP Mail</label>
    <input type="text" dir="ltr" value="{{ old('maxpop',$product->options['maxpop']) }}" class="form-control{{ $errors->has('maxpop') ? ' is-invalid' : '' }}" name="maxpop">
</div>
<div class="form-group">
    <label>تعداد Sub Domain</label>
    <input type="text" dir="ltr" value="{{ old('maxsub',$product->options['maxsub']) }}" class="form-control{{ $errors->has('maxsub') ? ' is-invalid' : '' }}" name="maxsub">
</div>
<div class="form-group">
    <label>تعداد Park Domain</label>
    <input type="text" dir="ltr" value="{{ old('maxpark',$product->options['maxpark']) }}" class="form-control{{ $errors->has('maxpark') ? ' is-invalid' : '' }}" name="maxpark">
</div>
<div class="form-group">
    <label>تعداد Addon Domain</label>
    <input type="text" dir="ltr" value="{{ old('maxaddon',$product->options['maxaddon']) }}" class="form-control{{ $errors->has('maxaddon') ? ' is-invalid' : '' }}" name="maxaddon">
</div>
