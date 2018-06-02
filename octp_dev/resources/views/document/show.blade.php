@extends('layouts.app')

@section('title')
{{$doc->title()}}
@endsection

@section('content')



    <div id="wrapper">

        <div class="container">



            <!-- Side navigation -->
            <div class="sidenav">

                Document name:
                <br>
                <strong>{{$doc->title()}}</strong>
                <br>
                <br>

                Language:
                <br>
                <strong>{{$doc->srcLanguage()->name}}</strong>
                <br>
                <br>

                Language requested:
                <br>
                <strong>{{$doc->wantedLanguageName()}}</strong>
                <br>
                <br>

                <span>Uploaded by:</span>
                <br>
                <strong>{{$doc->user->fullName()}}</strong>
                <br>
                <br>

                <span>Date:</span>
                <br>
                <strong>{{$doc->date_created}}</strong>
                <br>
                <br>


                @if(Auth::check() && ! \App\Helpers\Helper::hasUserReportedDocument(Auth::user(), $doc))
                    <button id="reportDocument" data-id= "{{ $doc->id }}" data-token={{ csrf_token() }}>Report</button>
                @endif

                @if(Auth::check() && ( Auth::id() == $doc->user->id || Auth::user()->isAdminOrModerator() ) )
                    <a href="/document/destroy/{{$doc->id}}">
                        <button>Delete</button>
                    </a>
                @endif



            </div>



            <div class="main">

                <br>
                <br>

                <p><strong>{{$doc->title()}}</strong></p>

                <p>

                    @foreach ($doc->sentences as $sentence)
                        <span class="sentence" id="sentence_{{$sentence->id}}">{{$sentence->text}} </span>
                    @endforeach

                </p>

            </div>



            <div class="translations">

                <br>

                Translations:

                <br>
                <br>

                <table class="table table-striped">

                    <tr>
                        <th style="width:auto">Original sentence</th>
                        <th style="max-width:200px">Translated sentence</th>
                        <th style="min-width:100px">Rating</th>
                        <th style="min-width:100px">My rating</th>
                    </tr>

                    @foreach ($doc->sentences as $sentence)

                        @php
                            //$allTranslations = \App\Translation::where('sentence_id', $sentence->id);
                            $allTranslations = $sentence->translations;
                        @endphp

                        @foreach ($allTranslations as $translation)

                            <tr>

                                <td>{{$sentence->text}}</td>

                                <td>{{$translation->translation_text}}</td>

                                <td>
                                    @php
                                        $averageRating = (int) $translation->average_rating ;
                                        RatingHelper::displayRatingStars($averageRating);
                                    @endphp
                                </td>

                                <td>
                                    @php
                                    $myRating = $translation->ratings()->where('user_id', Auth::id())->first();
                                    if($myRating != null) {
                                        RatingHelper::displayRatingStars($myRating->rating_value);
                                    }
                                    @endphp
                                </td>

                            </tr>

                        @endforeach
                    @endforeach

                </table>

            </div>



        </div>

    </div>

@endsection

@section('script')


    <script>
        var $executed = false;
        $(document).ready(function(){

            $('#reportDocument').click(function() {
                var explanation = prompt('Enter reason why are you reporting this document:');
                var token = $('#reportDocument').data('token');
                var docId = $('#reportDocument').data('id');
                if(explanation != null) {
                    // redirect
                    // TODO: escape 'explanation'
                    //location.href = "/report/store/?docId={{$doc->id}}&explanation=" + explanation;
                    $.ajax({
                        url: "{{ route("report.store") }}",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'id': docId,
                            'explanation': explanation,
                            '_token': token,
                        },
                        success: function(data) {
                            if (data.hasOwnProperty('success')) {
                                location.reload();
                            }
                        }
                    })
                }
            });

            $('span').click(function(event) {
                if (!$executed) {
                    $.noConflict(); //ne radi bez ovoga (sme da se izvrsi samo jednom inace ne zna sta je $)
                    $executed = true;
                }

                var sentenceID = Number(event.target.id.replace("sentence_", ""));
                var originalSentence = document.getElementById(event.target.id).innerText;
                $.confirm({
                    title: 'Translate',
                    content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Sentence to translate: ' + originalSentence + '</label>' +
                    '<input type="hidden" value="{{ csrf_token() }}" id="_token" name="_token" />' +
                    '<input type="text" placeholder="Enter your translation here" class="translation form-control" required />' +
                    '</div>' +
                    '</form>',
                    buttons: {
                        formSubmit: {
                            text: 'Submit',
                            btnClass: 'btn-blue',
                            action: function () {
                                var translatedSentenceText = this.$content.find('.translation').val();
                                // if(!name){
                                //     $.alert('provide a valid translation');
                                //     return false;
                                // }

                                var token = $('#_token').val();
                                //alert('sending ajax request: token=' + token);

                                jQuery.ajax({
                                        type: "POST",
                                        url: '/document/translate',
                                        dataType: 'json',
                                        data: { "sentenceId": sentenceID, "_token": token, "text": translatedSentenceText },
                                        success: function(reply){
                                            if (reply['result'] == "Success") {
                                                alert("Translation successfuly added!");
                                            } else {
                                                alert("Failed to add translation! :(");
                                            }
                                        },
                                        error: function (request, status, error) {
                                            //alert(request.responseText);
                                            //alert(status);
                                            //alert(error);
                                            alert("Failed to add translation! :(");
                                        }
                                    }
                                );
                                //$.alert('Your translation is: ' + translatedSentenceText);

                                //alert('ajax request is sent');
                            }
                        },
                        cancel: function () {
                            //close
                        },
                    },
                    onContentReady: function () {
                        // bind to events
                        var jc = this;
                        this.$content.find('form').on('submit', function (e) {
                            // if the user submits the form by pressing enter in the field.
                            e.preventDefault();
                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                        });
                    },
                    draggable: true,

                });
            });


        });

    </script>
@endsection
