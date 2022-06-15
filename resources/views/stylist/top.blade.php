<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"  crossorigin="anonymous"></script>
</head>
<body>
        {{-- {{ $stylist_list->links() }}
    {{ var_dump($stylist_list) }} --}}
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            @if ($stylist_list->currentpage()-1)
                <li class="page-item">
                    <a class="page-link" href="{{ $stylist_list->previousPageUrl() }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    </a>                    
                </li>          
                <li class="page-item"><a class="page-link" href="{{ $stylist_list->previousPageUrl() }}">{{ $stylist_list->currentPage() -1}}</a></li>
            @endif
          <li class="page-item active "><span class="page-link">{{ $stylist_list->currentPage() }}</span></li>
          @if ($stylist_list->currentpage()!=$stylist_list->lastPage())
          <li class="page-item"><a class="page-link" href="{{  $stylist_list->nextPageUrl()}}">{{ $stylist_list->currentPage() +1}}</a></li>
          <li class="page-item">
            <a class="page-link" href="{{  $stylist_list->nextPageUrl()}}" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>              
          @endif
        </ul>
      </nav>
</body>
</html>