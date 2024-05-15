<!DOCTYPE html>
<html>

<head>
    <title>Calculatrice basique</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Calculatrice Simple</h1>

        <form id="calculator-form">
            @csrf
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="expression">Expression:</label>
                        <input type="text" class="form-control" id="expression" name="expression"
                            value="{{ old('expression') }}" required>
                        <div class="invalid-feedback" id="expression-error"></div>
                    </div>
                    <h2 class="mt-3" id="result"></h2>
                </div>
                <div class="col-md-2">
                    <div class="form-group d-flex flex-column my-3">
                        <button type="button" class="btn btn-primary operation my-2" data-operation="+">+</button>
                        <button type="button" class="btn btn-primary operation my-2" data-operation="-">-</button>
                        <button type="button" class="btn btn-primary operation my-2" data-operation="*">*</button>
                        <button type="button" class="btn btn-primary operation my-2" data-operation="/">/</button>
                        <button type="submit" class="btn btn-success my-2">Résultat</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('.operation').click(function() {
                var operation = $(this).data('operation');
                var expressionField = $('#expression');
                expressionField.val(expressionField.val() + operation);
            });
            // Soumission du formulaire en ajax pour eviter le reload de la page
            $('#calculator-form').submit(function(event) {
                event.preventDefault();
                var expression = $('#expression').val();
                var token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ route('calculate') }}",
                    type: "POST",
                    data: {
                        _token: token,
                        expression: expression
                    },
                    success: function(response) {
                        $('#result').text('Résultat: ' + response.result);
                        $('#expression-error').text('').removeClass('d-block');
                        $('#expression').removeClass('is-invalid');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            if (errors && errors.expression) {
                                $('#expression-error').text(errors.expression[0]).addClass('d-block');
                            } else {
                                $('#expression-error').text(xhr.responseJSON.result).addClass('d-block');
                            }
                            $('#expression').addClass('is-invalid');
                        } else {
                            $('#result').text('Erreur : ' + xhr.responseJSON.result);
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
