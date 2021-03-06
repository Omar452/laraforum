@props(['subject' => $subject])

<div class="flex flex-col">
    @forelse($subject->comments as $comment)
    <!--SUBJECT ANSWERS-->
    <div class="bg-gray-100 p-2 my-2 w-3/4">     
        <div class="flex text-xs mb-5 ">
            <p>Posted the {{$comment->created_at->format('d/m/Y \a\t H:m')}} by <span class="text-bold">{{$comment->user->name}}</p></span>
        </div>

        <div class="flex mb-5 justify-between items-center">
            <p>{{$comment->content}}</p>
            <!--VUEJS COMPONENT TO MARK COMMENTS AS SOLUTION-->
            @auth
                @if(!$subject->solution && $subject->user_id === auth()->user()->id)
                    <div id="app">
                        <solution-component subject="{{$subject->title}}" comment="{{$comment->id}}"></solution-component>
                    </div>
                @else
                    @if($subject->solution && $subject->solution === $comment->id)
                    <div class="text-center solutionDiv">
                        <p class="bg-green-300 text-sm py-1 px-2 uppercase rounded-lg text-gray-900">marked as solution</p>
                    </div>
                    @endif
                @endif
            @endauth
            
        </div>

        <div class="flex justify-start text-sm mt-5">
            @can('update', $comment)
            <div class="mr-2">
                <a class="text-yellow-600" href="{{route('subjects.edit', $comment)}}">Edit</a>
            </div>
            @endcan
            @can('delete', $comment)
            <div>
                <button class="show-modal bg-none text-red-500 focus:outline-none">Delete</button>
            </div>
            @endcan
        </div>
    </div>

    <div class="mt-2">
        <button onclick="toggleReplyComment({{$comment->id}})" id="replyFormBtn-{{$comment->id}}" class="text-sm bg-gray-500 text-white px-2 py-1 rounded  hover:bg-gray-800">Reply to this comment</button>
    </div>

    <!--REPLY TO COMMENT FORM-->
    <div id="replyFormDiv-{{$comment->id}}" class="hidden my-5 ml-5">
        <form action="{{route('comments.storeReply', $comment)}}" method="POST">
            @csrf
        
            <div class="flex flex-col focus ml-5">
                <x-labelComponent>Your Reply:</x-labelComponent>
                <x-textareaComponent class="@error('reply') is-invalid @enderror" name="reply" id="reply" rows="5">{{old('reply') ?? NULL}}</x-textareaComponent>
        
                @error('reply')
                <x-errorDivComponent>{{$message}}</x-errorDivComponent>
                @enderror
            </div>
        
            <div class="mt-2 ml-5">
                <button class="text-sm bg-gray-500 text-white px-2 py-1 rounded  hover:bg-gray-800">Submit your reply</button>
            </div>
        </form>
    </div>

    <!--REPLIES-->
    @foreach ($comment->comments as $reply)
    <div class="bg-gray-100 p-2 my-2 w-3/4 self-end">
        
        <div class="flex text-xs mb-5 ">
            <p>Posted the {{$reply->created_at->format('d/m/Y \a\t H:m')}} by <span class="text-bold">{{$reply->user->name}}</p></span>
        </div>

        <div class="flex mb-5 justify-between">
            <p>{{$reply->content}}</p>
            <div id="solution" subject="{{$subject}} comment="$comment"></div>
        </div>

        <div class="flex justify-start text-sm">
            @can('update', $reply)
            <div class="mr-2">
                <a class="text-yellow-600" href="{{route('subjects.edit', $reply)}}">Edit</a>
            </div>
            @endcan
            @can('delete', $reply)
            <div>
                <button class="show-modal bg-none text-red-500 focus:outline-none">Delete</button>
            </div>
            @endcan
        </div>
    </div>
    @endforeach

    @empty
        <p>Do you want to comment this subject?</p>
    @endforelse
</div>

<script>
    function toggleReplyComment(id){
        let element = document.querySelector('#replyFormDiv-' + id);
        element.classList.toggle("hidden");
    }

    if(document.querySelector('.solutionDiv')){
        let solutionDiv = document.querySelector('.solutionDiv');
        console.log(solutionDiv.parentElement)
        solutionDiv.parentElement.parentElement.style.border = "solid 2px #10B981";
        solutionDiv.parentElement.parentElement.style.borderRadius = "5px";
    }
</script>