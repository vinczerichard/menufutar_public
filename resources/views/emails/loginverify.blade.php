<html>

<head>
    <style>
        a {
            text-decoration: none;
        }

        a:hover {

            text-decoration: none;
        }

        a:not([href]) {
            color: inherit;
            text-decoration: none;
        }

        a:not([href]):hover {
            color: inherit;
            text-decoration: none;
        }

        .text-secondary {
            color: #6c757d !important;
        }

        a.text-secondary:hover,
        a.text-secondary:focus {
            color: #494f54 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        a.text-success:hover,
        a.text-success:focus {
            color: #19692c !important;
        }

        .text-info {
            color: #17a2b8 !important;
        }

        a.text-info:hover,
        a.text-info:focus {
            color: #0f6674 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        a.text-warning:hover,
        a.text-warning:focus {
            color: #ba8b00 !important;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        a.text-danger:hover,
        a.text-danger:focus {
            color: #a71d2a !important;
        }

        .text-light {
            color: #f8f9fa !important;
        }

        a.text-light:hover,
        a.text-light:focus {
            color: #cbd3da !important;
        }

        .text-dark {
            color: #343a40 !important;
        }

        a.text-dark:hover,
        a.text-dark:focus {
            color: #121416 !important;
        }

        .text-body {
            color: #212529 !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .btn-warning {
            color: #212529;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            color: #212529;
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-primary:focus,
        .btn-primary.focus {
            color: #fff;
            background-color: #0069d9;
            border-color: #0062cc;
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .btn-primary.disabled,
        .btn-primary:disabled {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:not(:disabled):not(.disabled):active,
        .btn-primary:not(:disabled):not(.disabled).active,
        .show>.btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #0062cc;
            border-color: #005cbf;
        }

        .btn-primary:not(:disabled):not(.disabled):active:focus,
        .btn-primary:not(:disabled):not(.disabled).active:focus,
        .show>.btn-primary.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.5);
        }

        .btn-outline-primary {
  color: #007bff;
  border-color: #007bff;
}

.btn-outline-primary:hover {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.btn-outline-primary:focus, .btn-outline-primary.focus {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}

.btn-outline-primary.disabled, .btn-outline-primary:disabled {
  color: #007bff;
  background-color: transparent;
}

.btn-outline-primary:not(:disabled):not(.disabled):active, .btn-outline-primary:not(:disabled):not(.disabled).active,
.show > .btn-outline-primary.dropdown-toggle {
  color: #fff;
  background-color: #007bff;
  border-color: #007bff;
}

.btn-outline-primary:not(:disabled):not(.disabled):active:focus, .btn-outline-primary:not(:disabled):not(.disabled).active:focus,
.show > .btn-outline-primary.dropdown-toggle:focus {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.5);
}
    </style>
</head>

<body>
    <div class="container-fluid">
        <div>
            {!! $text !!}
        </div>
    </div>




</body>

</html>
