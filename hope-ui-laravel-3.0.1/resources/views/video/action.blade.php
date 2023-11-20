<div class="flex align-items-center list-user-action">
    <a data-bs-toggle="modal" data-bs-target="#viewDetail" data-bs-toggle="tooltip" title="View Detail" class="view-detail-button" >
        <span class="btn-inner">
            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.334 2.75H7.665C4.644 2.75 2.75 4.889 2.75 7.916V16.084C2.75 19.111 4.635 21.25 7.665 21.25H16.333C19.364 21.25 21.25 19.111 21.25 16.084V7.916C21.25 4.889 19.364 2.75 16.334 2.75Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9946 16V12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M11.9896 8.2041H11.9996" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
       </span>
    </a>
    <a data-bs-toggle="tooltip" title="Edit Video" href="{{ route('videos.edit',$id) }}">
        <span class="btn-inner">
            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>
    </a>
    @if((auth()->user()->hasRole('admin') && auth()->id() !== $id) || !auth()->user()->hasRole('admin'))
    <?php 
    $message = __('global-message.delete_alert', ['form' => __('users.title2')])
    ?>
    <a onclick="return confirm('{{$message}}') ? document.getElementById('user-delete-{{$id}}').submit() : false" data-bs-toggle="tooltip" title="Delete User" href="#">
        <span class="btn-inner">
            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
        </span>
    </a>
    <form action="{{route('videos.destroy',$id)}}" id="user-delete-{{$id}}" method="post">
        @method('delete')
        @csrf()
    </form>
    @endif
</div>

<div class="modal" id="viewModel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="px-4 my-2 text-center">
                    <h3 class="text-lg md:text-2xl mb-6 text-gray-800 font-medium">View Details</h3>
                </div>
                <button type="button" class="btn-close" id="closeModalButton" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                                <label class="text-sm text-gray-500 w-40 text-left" style="width: 100px;">Media</label>
                                <span class="text-sm text-gray-500 text-left" style="margin-right: 5px;">:</span>
                                <a href="" class="text-sm text-gray-800 font-medium max-w-xs truncate" id="mediaLink" target="_blank" style="border: none; font-weight: bold; width: 100px;">click</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px solid #ccc; margin: 5px 0; padding: 0; width: 97%">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                                <label class="text-sm text-gray-500 w-40 text-left" style="width: 100px;">CP-ID</label>
                                <span class="text-sm text-gray-500 text-left" style="margin-right: 5px;">:</span>
                                <input type="text" class="text-sm text-gray-800 font-medium max-w-xs truncate" name="cp_id" id="cp_id" readonly style="border: none; font-weight: bold; width: 100px;">
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border: 1px solid #ccc; margin: 5px 0; padding: 0; width: 97%">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group d-flex align-items-center">
                            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                                <label class="text-sm text-gray-500 w-40 text-left" style="width: 100px;">Description</label>
                                <span class="text-sm text-gray-500 text-left" style="margin-right: 5px;">:</span>
                                <input type="text" class="text-sm text-gray-800 font-medium max-w-xs truncate" name="description" id="description" readonly style="border: none; font-weight: bold; width: 100px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
    $('#dataTable').on('click', 'tbody .view-detail-button', function() {
        var rowData = $('#dataTable').DataTable().row($(this).closest('tr')).data();
        var categoryFolder = rowData.category.name; 
        var baseFolder = 'uploads/' + categoryFolder + '/';
        var mediaRelativeURL = rowData.media;
        var fullMediaURL = baseFolder + mediaRelativeURL;

        $('#cp_id').val(rowData.cp_id);
        $('#description').val(rowData.description);
        $('#mediaLink').attr('href', fullMediaURL);
        $('#viewModel').modal('show');
    });
});
    $('#closeModalButton').on('click', function() {
        $('#viewModel').modal('hide');
        event.stopPropagation();
    });

</script>
