
<table class="default" style="width: 100%;" id="denuncias">
    <thead>
        <tr style="width: 100%; text-align: center !important">
            <th>N°</th>
            <th>Victima</th>
            <th>Fecha</th>
            <th>Descripción</th>
            <th>Datos del agresor</th>
            <th>Evidencia</th>
        </tr>
    </thead>
    <tbody id="data_view">
        @foreach ($data as $row)
        <tr>
            <td>{{ $row->id }}</td>
            <td>{{ $row->id_victima }}</td>
            <td>{{ $row->created_at }}</td>
            <td>{{ $row->descripcion }}</td>
            <td>{{ $row->datos_agresor }}</td>
            <td>{{ $row->evidencia_media }}</td>
        </tr>
        @endforeach
    </tbody>
</table>