@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col col-md-2">
        <nav class="panel panel-default">
          <div class="panel-heading">テーマ</div>
          <div class="panel-body">
            <a href="{{ route('kinds.create') }}" class="btn btn-default btn-block">
              テーマ追加
            </a>
          </div>
          <div class="list-group">
            
            @foreach($kinds as $kind)
              <!-- 選択箇所をアクティブ-->  
              <a href="{{ route('books.index', ['kind_id' => $kind->id]) }}" 
              class="list-group-item {{ $current_kind_id === $kind->id ? 'active' : '' }}">
                {{ $kind->name }}
              </a>
            @endforeach
          </div>
        </nav>
      </div>
      <div class="column col-md-10">
        <!-- ここにタスクが表示される -->
        <div class="panel panel-default">
            <div class="panel-heading">ストーリー</div>
            <div class="panel-body">
                <div class="text-right">
                <a href="{{ route('books.create', ['kind_id' => $current_kind_id]) }}" class="btn btn-default btn-block">
                    ストーリー追加
                </a>
                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                <th>ストーリー</th>
                <th>いいね</th>
                <th>期限</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr>
                    <td>{{ $book->story }}</td>
                    <td>
                        <span class="label {{ $book->status_class }}">{{ $book->status_label }}</span>
                    </td>
                    <td>{{ $book->formatted_due_date }}</td>
                    <td><a href="{{ route('books.relay', ['id' => $book->id]) }}">リレー</a></td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
@endsection