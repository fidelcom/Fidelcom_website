<div class="social-share">
    @php
        $url = urlencode($url ?? url()->current());
        $title = urlencode($title ?? config('app.name'));
    @endphp

    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}" target="_blank">Facebook</a>
    <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}" target="_blank">Twitter</a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}" target="_blank">LinkedIn</a>
    <a href="https://wa.me/?text={{ $title }}%20{{ $url }}" target="_blank">WhatsApp</a>
</div>

<x-social-share :url="route('posts.show', $post->id)" :title="$post->title" />
