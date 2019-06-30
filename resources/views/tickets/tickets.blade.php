@extends('layouts.app')

@section('content')
    <div class="inner_panal">
        <section class="Message">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>
                            الرقم
                        </th>
                        <th>
                            اسم الراسل
                        </th>
                        <th>
                            الهاتف
                        </th>
                        <th>
                            البريد الالكتروني
                        </th>

                        <th>
                           عنوان الرساله
                        </th>
                        <th>
                           الرساله
                        </th>
                        <th>
                           الاجراءت
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {!! $results!!}
                    </tbody>
                </table>
                {!! $links->links() !!}
            </div> <!-- end table-responsive -->
        </section> <!-- end Message -->

    </div> <!-- end inner_panal -->

@endsection
