
function batal_suratjalan(id)
{
	$('input.surat_jalan_id').val(id);
	$('#modal_surat_jalan').modal("show");
}