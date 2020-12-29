@component('mail::message')
# Gratulacje! Wymieniłeś jeden token na przedmiot użytkownika {{ $transaction->item->user->username }}.
Tytuł ogłoszenia: {{ $transaction->item->title }}<br><br>
Skontaktuj się ze sprzedawcą w celu uzgodnienia szczegółów odbioru przedmiotu.<br>

Pozdrawiamy,<br>
Zespół serwisu Baster
@endcomponent
