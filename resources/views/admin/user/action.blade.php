<a href="{{ route('admin.user.edit',['id' => $id]) }}" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> ویرایش</a>
<form method="post" action="{{ route('admin.user.delete',['id' => $id]) }}" style="display:inline;">
    @csrf
    @method('delete')
    <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')" class="btn btn-danger btn-sm btn-mobile"><i
                class="fa fa-trash"></i> حذف
    </button>
</form>
<a href="{{ route('admin.invoice.create.user',['id' => $id]) }}" class="btn btn-sm btn-warning"><i
            class="fa fa-calculator" aria-hidden="true"></i> فاکتور<a>
