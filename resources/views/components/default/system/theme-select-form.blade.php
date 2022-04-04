<form action="{{ route('settings.design.store') }}" method="POST">
    @csrf

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="theme">{{ translate('Select Theme for :') }}
                    {{ $domain->domain }}
                    <br> ({{ translate('Current Theme') }}): {{ $currentTheme }}</label>
                <select name="theme" class="form-control">
                    @foreach ($themes as $theme)
                    <option value="{{ $theme }}" {{ $theme==$currentTheme ? 'selected' : '' }}>{{ $theme }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary-outline" value="{{ translate('Save') }}">
            </div>
        </div>
</form>
