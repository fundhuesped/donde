<div class="col s2">
  <a  onclick="window.history.go(-1); return false;" class="left waves-effect waves-light btn-floating btn-flat green"><i class="material-icons">arrow_back</i></a>
</div>
<div class="col s4">
  <p> </p>
</div>
<div class="col s2">
  <div class="valign-demo  valign-wrapper">
    <div class="valign full-width actions">

      <button class="waves-effect waves-light btn btn-small green" ng-href="" ng-disabled="spinerflag" ng-click="clicky()">

      <div class="preloader-wrapper small active" ng-cloak ng-show="spinerflag">
        <div class="spinner-layer spinner-red-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
            <div class="circle"></div>
          </div><div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>

      <div class="" ng-cloak ng-show="!spinerflag">
        <i class="mdi-content-save left"></i>
        <span translate="save"></span>
      </div>

    </button>
  </div>
</div>
</div>
<div class="col s2">
  <div class="valign-demo  valign-wrapper">
    <div class="valign full-width actions">
      <button class="waves-effect waves-light btn btn-small green"
      ng-href="" ng-disabled="spinerflag" ng-click="clickyApr()">

      <div class="preloader-wrapper small active" ng-cloak ng-show="spinerflag">
        <div class="spinner-layer spinner-red-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
            <div class="circle"></div>
          </div><div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>

      <div class="" ng-cloak ng-show="!spinerflag">
        <i class="mdi-action-done  left"></i>
        <span translate="approve"></span>
      </div>

    </button>
  </div>
</div>
</div>

<div class="col s2">
  <div class="valign-demo  valign-wrapper">
    <div class="valign full-width actions">
      <button class="waves-effect waves-light btn btn-small red "
      ng-href="" ng-disabled="spinerflag" ng-click="clickyDis()">

      <div class="preloader-wrapper small active" ng-cloak ng-show="spinerflag">
        <div class="spinner-layer spinner-red-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
            <div class="circle"></div>
          </div><div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>

      <div class="" ng-cloak ng-show="!spinerflag">
        <i class="mdi-av-not-interested  left"></i>
        <span translate="reject"></span>
      </div>

    </button>
  </div>
</div>
</div>