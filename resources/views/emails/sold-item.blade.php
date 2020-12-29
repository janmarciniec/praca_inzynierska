@component('mail::message')
# Użytkownik {{ $transaction->user->username }} kupił Twój przedmiot.
Tytuł ogłoszenia: {{ $transaction->item->title }}<br><br>
W sekcji "Sprzedane przedmioty" na Twoim profilu znajdują się szczegóły dotyczące transakcji.<br>

Pozdrawiamy,<br>
Zespół serwisu Baster
@endcomponent
