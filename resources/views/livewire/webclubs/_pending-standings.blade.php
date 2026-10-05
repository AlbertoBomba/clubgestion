@for ($slot = 1; $slot <= $pendingCount; $slot++)
    <tr>
        <td style="padding: 12px; text-align: center;">{{ $assignedCount + $slot }}</td>
        <td style="padding: 12px; color: #64748b;">Equipo {{ $assignedCount + $slot }} · por definir</td>
        @for ($stat = 0; $stat < 8; $stat++)
            <td class="{{ $stat >= 5 && $stat <= 6 ? 'hidden sm:table-cell' : ($stat === 7 ? 'hidden xs:table-cell sm:table-cell' : '') }}"
                style="padding: 12px; text-align: center; color: #64748b;">—</td>
        @endfor
    </tr>
@endfor
@if ($assignedCount === 0 && $pendingCount === 0)
    <tr>
        <td colspan="10" style="padding: 24px; text-align: center; color: #64748b;">Sin equipos asignados aún.</td>
    </tr>
@endif
