@component('mail::message')
# Twoje ogłoszenie "{{ $item->title }}" zostało usunięte przez nasz zespół.

Możliwe powody usunięcia:
<ul>
    <li>ogłoszenie zawierało niewłaściwe treści,</li>
    <li>zdjęcie nie przedstawiało ogłaszanego przedmiotu,</li>
    <li>ogłaszany przedmiot był mało widoczny na zdjęciu,</li>
    <li>ogłoszenie wskazywało na chęć spieniężenia ogłaszanego przedmiotu,</li>
    <li>ogłoszenie stanowiło reklamę.</li>
</ul>

<br>Jeśli uważasz, że ogłoszenie zostało usunięte niesłusznie - skontaktuj się z nami.<br>

Pozdrawiamy,<br>
Zespół serwisu Baster
@endcomponent
