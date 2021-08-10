<div class="display-4 fw-400">

    @if ($company->youtube != null)
        <a href="{{ $company->youtube }}" target="_blank">
            <i class="lab la-linkedin"></i>
        </a>
    @endif
    @if ($company->facebook != null)
        <a href="{{ $company->facebook }}" target="_blank">
            <i class="lab la-facebook"></i>
        </a>
    @endif

    @if ($company->google != null)
        <a href="{{ $company->google }}" target="_blank">
            <i class="lab la-instagram"></i>
        </a>
    @endif

    @if ($company->twitter != null)
        <a href="{{ $company->twitter }}" target="_blank">
            <i class="lab la-twitter"></i>
        </a>
    @endif
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
</div>
