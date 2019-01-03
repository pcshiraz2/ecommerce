<a href="{{ route('admin.account.edit',['id' => $id]) }}" class="btn btn-sm btn-dark"><i
            class="fa fa-edit btn-mobile"></i> ویرایش</a>
<form method="post" action="{{ route('admin.account.delete',['id' => $id]) }}" style="display:inline;">
    @csrf
    @method('delete')
    <button onclick="return confirm('آیا از عملیات حذف اطمینان دارید؟')" class="btn btn-danger btn-sm btn-mobile"><i
                class="fa fa-trash"></i> حذف
    </button>
</form>