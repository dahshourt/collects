{{--
  Reusable Logs Modal
  -------------------
  Include this partial at the bottom of any page that needs a Logs button.

  Usage in your Blade view:

    @include('partials.logs_modal', [
        'logsCategory' => 'Report',    // User | Group | Workflow | Report
        'logsSection'  => 'CM Report', // optional sub-label
        'logsTitle'    => 'CM Report Logs',
    ])

  Then add the trigger button wherever you want:
    <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#logsModal">
        <i class="fa fa-history"></i> Logs
    </button>
--}}

<!-- Logs Modal -->
<div class="modal fade" id="logsModal" tabindex="-1" role="dialog" aria-labelledby="logsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title" id="logsModalLabel">
          <i class="fa fa-history mr-1"></i>
          {{ $logsTitle ?? ($logsCategory ?? 'System') . ' Logs' }}
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
        <div id="logsModalContent">
          <div class="text-center py-4">
            <div class="spinner-border text-secondary" role="status">
              <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading logs&hellip;</p>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <small class="text-muted mr-auto">Showing latest 100 entries</small>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<script>
(function () {
    var logsCategory = '{{ $logsCategory ?? '' }}';
    var logsSection  = '{{ $logsSection  ?? '' }}';

    $('#logsModal').on('show.bs.modal', function () {
        var $content = $('#logsModalContent');
        $content.html(
            '<div class="text-center py-4">'
            + '<div class="spinner-border text-secondary" role="status"></div>'
            + '<p class="mt-2 text-muted">Loading logs&hellip;</p>'
            + '</div>'
        );

        var params = { category: logsCategory };
        if (logsSection) params.section = logsSection;

        $.ajax({
            url: '{{ route("administration.logs") }}',
            method: 'GET',
            data: params,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                $content.html(response.html);
            },
            error: function (xhr) {
                if (xhr.status === 403) {
                    $content.html('<div class="alert alert-danger m-3">You do not have permission to view logs.</div>');
                } else {
                    $content.html('<div class="alert alert-warning m-3">Failed to load logs. Please try again.</div>');
                }
            }
        });
    });
}());
</script>
