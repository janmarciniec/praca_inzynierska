@component('mail::message')
# Twoje ogłoszenie "{{ $item->title }}" znajdowało się w niewłaściwej kategorii.

Przenieśliśmy je do kategorii "{{ $item->category->name }}".

Pozdrawiamy,<br>
Zespół serwisu Baster
@endcomponent
