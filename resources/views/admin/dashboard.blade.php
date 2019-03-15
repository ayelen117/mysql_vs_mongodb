@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <h4>Base de datos relacionales vs. no relacionales</h4>
        <p>
            El crecimiento constante del comercio web y aparición de nuevas tecnologías han presentado nuevos retos para
            el mundo informático. El volumen de datos aumenta día a día y las aplicaciones tienen que enfrentarse con el
            manejo eficiente de estos, es por ello que la elección de un modelo de base de datos se convierte en un
            punto muy importante en el desarrollo de un software.
            Si bien las base de datos relacionales (RDB) han estado en la cúspide por los últimos 30 años, muchas
            compañías han migrado sus sistemas a un nuevo concepto de base de datos denominado no relacional (NoSQL).
            Es en este punto donde nos preguntamos ¿Por qué empresas como Facebook y Amazon se han inclinado por este
            nuevo modelo? ¿Cuales son las ventajas y desventajas de las bases de datos no relacionales?
            Esta aplicación tiene como objetivo hacer un estudio comparativo entre la base de datos relacional MySQL y
            la no relacional MongoDB basándose en métricas obtenidas mediante la ejecución de diferentes operaciones
            en un gran volumen de datos.
        </p>
    </div>
@endsection

@section('scripts')
@endsection
