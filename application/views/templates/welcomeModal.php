
    <div class="modal-header">
      <h3 class="modal-title">Welcome</h3>
    </div>
    <div class="modal-body">
      <h5>Dice 1</h5>
      <input ng-model="seeds.seed_1" />
      <h5>Dice 2</h5>
      <input ng-model="seeds.seed_2" />
      <h5>Dice 3</h5>
      <input ng-model="seeds.seed_3" />
      <h5>Dice 4</h5>
      <input ng-model="seeds.seed_4" />
      <h5>Dice 5</h5>
      <input ng-model="seeds.seed_5" />
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" ng-click="ok()">OK</button>
    </div>