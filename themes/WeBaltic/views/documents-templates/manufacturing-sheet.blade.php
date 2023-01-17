<style>
    td {
        padding: 5px;
    }

    table,
    th,
    td {
        border: 1px solid;
    }

    table {
        border-collapse: collapse;
    }
</style>

<table style="width: 100%;">
    <tr>
        <td colspan="4">
            {{ translate('Suvirinimo gamybos lapas') }}
        </td>
    </tr>

    <tr>
        <td>
            {{ translate('Gamybos numeris:') }}
        </td>
        <td>
            {{ $order->id }}
        </td>

        <td>
            {{ translate('Komercinio pasiulymo nr:') }}
        </td>
        <td>
            {{ $order->id }}
        </td>
    </tr>


</table>
