<div class="embed-responsive embed-responsive-16by9">
    @if ($product->video_provider == 'youtube' && isset(explode('=', $product->video_link)[1]))
        <iframe class="embed-responsive-item"
            src="https://www.youtube.com/embed/{{ explode('=', $product->video_link)[1] }}"></iframe>
    @elseif ($product->video_provider == 'dailymotion' &&
        isset(explode('video/', $product->video_link)[1]))
        <iframe class="embed-responsive-item"
            src="https://www.dailymotion.com/embed/video/{{ explode('video/', $product->video_link)[1] }}"></iframe>
    @elseif ($product->video_provider == 'vimeo' &&
        isset(explode('vimeo.com/', $product->video_link)[1]))
        <iframe
            src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $product->video_link)[1] }}"
            width="500" height="281" frameborder="0" webkitallowfullscreen
            mozallowfullscreen allowfullscreen></iframe>
    @endif
</div>
