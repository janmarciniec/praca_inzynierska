@component('mail::message')
# Odpowiedż na Twoje zgłoszenie numer #{{ $claim->id }} dotyczące zakupu przedmiotu "{{ $claim->transaction->item->title }}":
{{ $claim->reply }}<br><br>
Pozdrawiamy,<br>
Zespół serwisu Baster
@endcomponent
