@auth
                        <x-panel>
                            <form method="POST" action="/posts/{{ $post->slug }}/comments" >
                                @csrf

                                <header class="flex items-center">
                                    <img src="https://i.pravatar.cc/40?u={{ auth()->id() }}" alt="" width="40" class="rounded-full" />
                                    <h2 class="ml-4">Want to participate?</h2>
                                </header>

                                <x-form.textarea name="body" showlabel="false" />

                                <x-form.button>
                                    Post
                                </x-form.button>

                            </form>
                        </x-panel>
                    @else
                        <p class="font-semibold">
                            <a href="/register" class="hover:underline">Register</a> OR
                            <a href="/login" class="hover:underline">log in to leave a comment!</a>
                        </p>
                    @endauth
