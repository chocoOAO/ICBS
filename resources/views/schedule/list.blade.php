<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            生長標準預估
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-2 pb-5 border-gray-200 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-lg leading-6 font-medium text-gray-900"></h3>
                <div class="mt-3 sm:mt-0 sm:ml-4">
                    <label for="mobile-search-candidate" class="sr-only">Search</label>
                    <label for="desktop-search-candidate" class="sr-only">Search</label>
                    <div class="flex rounded-md shadow-sm">
                        <div class="relative flex-grow focus-within:z-10">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <!-- Heroicon name: solid/search -->
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <form action="#" method="GET">
                                {{-- <input type="text" name="mobile-search-candidate" id="mobile-search-candidate" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full rounded-md pl-10 sm:hidden border-gray-300" placeholder="搜尋"> --}}
                                <input type="text" name="search" id="desktop-search-candidate"
                                    class="hidden focus:ring-indigo-500 focus:border-indigo-500 w-full rounded-md pl-10 sm:block sm:text-sm border-gray-300"
                                    placeholder="搜尋" value="{{ request()->get('search') }}">
                                <input type="submit" hidden />
                            </form>

                        </div>

                    </div>

                </div>
            </div>

            {{-- a --}}

            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
            <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

            {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.1/index.global.min.js'></script> --}}

            <div id="calendar" style="background-color:white;padding:10px;margin-bottom:5px; border-radius:10px"></div>
            <style>
                .fc-content {
                    overflow: visible !important;
                    white-space: normal !important; /* 顯示多行文字 */
                    transition: transform 0.3s ease;
                    z-index: 1;
                }

            </style>
            <script>
                $(document).ready(function() {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    
                    var calendar = $('#calendar').fullCalendar({
                        // editable: true,
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        events: '/schedule',
                        dragOpacity: "0.5",
                        //
                        // eventDrop: function(event, delta, revertFunc) {

                        //     alert(event.title + " was dropped on " + event.start.format());

                        //     if (!confirm("Are you sure about this change?")) {
                        //         revertFunc();
                        //     }
                        // }
                        eventDrop: function(event, dayDelta, minuteDelta, allDay, revertFunc) {
                            $.post("do.php?action=drag", {
                                id: event.id,
                                daydiff: dayDelta,
                                minudiff: minuteDelta,
                                allday: allDay
                            }, function(msg) {
                                if (msg != 1) {
                                    alert(msg);
                                    revertFunc(); //恢复原状
                                }
                            });
                        }

                        //
                    });
                });
            </script>

        </div>
    </div>



</x-app-layout>
