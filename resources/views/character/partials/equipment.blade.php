<div class="text-center my-5">
    <a class="btn btn-primary" href="{{ route('location.show', ['location' => $character->getLocationId()]) }}">
        To {{ $character->getLocationName() }}
        <span class="fas fa-walking"></span>
    </a>
</div>

<h3 class="mt-5 text-center"> Equipment </h3>
<div class="my-3 row table-dark align-items-center">
    <div class="col-3 equipment-item">
        Head gear
    </div>
    <div class="col-3 equipment-item">
        Armor
    </div>
    <div class="col-3 equipment-item">
        Main hand
    </div>
    <div class="col-3 equipment-item">
        Off hand
    </div>
</div>