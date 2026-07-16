@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-zinc-950 text-zinc-100 flex">

    <!-- SIDEBAR -->
    <aside class="hidden w-72 flex-col border-r border-white/10 bg-black/40 lg:flex">

        @include('layouts.sidebar')

    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-6 space-y-6">

        <!-- HEADER -->

        <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
            <p class="text-sm uppercase tracking-widest text-orange-400">
                Admin Panel
            </p>
            <h1 class="mt-2 text-3xl font-bold text-white">
                🚩 Thread Reports
            </h1>
            <p class="mt-2 text-sm text-zinc-400">
                Review reported community posts
            </p>
        </div>

        <!-- REPORT LIST -->
        <div class="rounded-3xl border border-white/10 bg-white/5 overflow-hidden">
            <div class="p-5 border-b border-white/10">
                <h2 class="font-semibold text-white">
                    Report Queue
                </h2>
            </div>
            <div class="p-5 space-y-5">
                @forelse($reports as $report)
                <div class="rounded-2xl border border-white/10 bg-black/20 p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm text-zinc-400">
                                Reported by:
                                <span class="text-white">
                                    {{ $report->user->name }}
                                </span>
                            </p>
                            <p class="text-sm text-zinc-400">
                                Thread owner:
                                <span class="text-white">
                                    {{ $report->thread?->user?->name ?? 'Deleted User' }}
                                </span>
                            </p>
                        </div>
                        <span class="px-3 py-1 text-xs rounded-full
                            @if($report->status == 'pending')
                                bg-yellow-500/20 text-yellow-300
                            @elseif($report->status == 'resolved')
                                bg-red-500/20 text-red-300
                            @else
                                bg-green-500/20 text-green-300
                            @endif
                        ">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>
                    <hr class="my-4 border-white/10">
                    <h3 class="text-xl font-bold text-white">
                        {{ $report->thread?->title ?? 'Thread Deleted' }}
                    </h3>
                    <p class="mt-2 text-zinc-300">
                        {{ $report->thread?->content ?? 'This thread has been deleted.' }}
                    </p>
                    @if($report->thread->image)
                    <img src="{{ asset('storage/'.$report->thread->image) }}"
                        class="mt-4 rounded-xl max-h-60 object-cover">

                    @endif
                    <div class="mt-4 p-3 rounded-xl bg-orange-500/10 text-orange-300">
                        🚩 Reason:
                        {{ $report->reason }}
                    </div>
                    @if($report->details)
                    <p class="mt-3 text-sm text-zinc-400">
                        Details:
                        {{ $report->details }}
                    </p>
                    @endif
                <div class="mt-5 flex gap-3">

                    <!-- KEEP THREAD -->
                    <form method="POST"
                        action="{{ route('admin.reports.dismiss',$report->id) }}">
                        @csrf
                        @method('PATCH')
                        <button
                        onclick="return confirm('Keep this thread?')"
                        class="px-4 py-2 rounded-xl bg-green-500/20 text-green-300 text-sm">
                            ✅ Keep Thread
                        </button>
                    </form>

                    <!-- DELETE THREAD -->
                    <form method="POST"
                        action="{{ route('admin.reports.deleteThread',$report->thread_id) }}">
                        @csrf
                        @method('DELETE')
                        <button
                        onclick="return confirm('Delete this thread?')"
                        class="px-4 py-2 rounded-xl bg-red-500/20 text-red-300 text-sm">
                            🗑 Delete Thread
                        </button>
                    </form>
                </div>
                </div>
                @empty
                <div class="text-center text-zinc-500 py-10">
                    No reports found 🎉
                </div>
                @endforelse
            </div>
        </div>
    </main>
</div>
@endsection
