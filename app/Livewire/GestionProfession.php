<?php

namespace App\Livewire;

use App\Models\Organisation;
use App\Models\OrganisationProfessionnel;
use App\Models\OrganisationProfession;
use App\Models\ProfessionProfessionnel;
use App\Models\Profession;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;

class GestionProfession extends Component
{
    public $orgPro;
    public $idOrg;
    public $org;
    public $organisations;
    public $organisation;
    public $professions;
    public $professionsPro;
    public $profession;
    public $professionPro;
    public $numMembre;
    public $dateExpiration;
    public $today;
    public $idProfession;
    public $idOrganisation;
    public $idProfessionPro;
    public $idOrganisationProf;
    public $lienOrgPro;
    public $idOrgProProf;


    public function render()
    {
        return view('livewire.gestion-profession');
    }

    public function mount()
    {
        $this->orgPro = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->get();
        $this->idOrg = OrganisationProfessionnel::select('idOrganisation')->where('idProfessionnel', '=', Auth::user()->id)->get();
        $this->org = Organisation::whereIn('id', $this->idOrg)->get();
        $this->professions = Profession::all();
        $this->professionsPro = ProfessionProfessionnel::where('user_id', '=', Auth::user()->id)->get();
        $this->organisations = Organisation::all();
        Carbon::setLocale('fr_CA');

        // Obtenir l'heure actuelle en UTC
        $this->today = Carbon::now('America/Toronto');
    }

    protected function rules()
    {
        return [
            'profession' => 'required',
            'numMembre' => 'required_with:organisation',
            'dateExpiration' => 'required_with:organisation',
        ];
    }

    protected $messages = [
        'profession.required' => 'Veuillez entrer une profession.',
        'numMembre.required_with' => 'Veuillez entrer un numéro de membre.',
        'dateExpiration.required_with' => 'Veuillez entrer une date d\'expiration.',
    ];

    public function triOrg(): void
    {

        if ($this->profession == null) {
            $this->organisations = Organisation::all();
        } else {
            $proChoisi = Profession::select('id')->where('nom', '=', $this->profession);
            $orgPro = OrganisationProfession::select('idOrganisation')->where('idProfession', '=', $proChoisi);
            $this->organisations = Organisation::whereIn('id', $orgPro)->get();
        }
    }

    public function triProfession(): void
    {

        if ($this->organisation == null) {
            $this->professions = Profession::all();
        } else {
            $orgChoisi = Organisation::select('id')->where('nom', '=', $this->organisation);
            $orgPro = OrganisationProfession::select('idProfession')->where('idOrganisation', '=', $orgChoisi);
            $this->professions = Profession::whereIn('id', $orgPro)->get();
        }
    }

    public function formAjout()
    {
        $this->dispatch('open-modal', name: 'ajouterOrg');
    }

    public function formModif($lienOrgPro, $idProf, $idOrg)
    {
        #dd($lienOrgPro);
        $this->lienOrgPro = $lienOrgPro;
        $this->idProfession = $idProf;
        $profession = Profession::find($idProf);
        $this->professionPro = ProfessionProfessionnel::select('id')->where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->get();
        $lienProfPro = ProfessionProfessionnel::find($this->professionPro);
        $this->idProfessionPro = $lienProfPro[0]->id;
        $this->profession = $profession->nom;
        $this->idOrganisation = $idOrg;
        $this->numMembre = null;
        $this->dateExpiration = null;
        $this->organisation = null;
        if ($this->idOrganisation != null) {
            $organisationProf = OrganisationProfession::select('id')->where('idOrganisation', '=', $this->idOrganisation)->where('idProfession', '=', $this->idProfession)->get();
            $lienOrgProf = OrganisationProfession::find($organisationProf);
            $this->idOrganisationProf = $lienOrgProf[0]->id;
            $organisation = Organisation::find($idOrg);
            $this->organisation = $organisation->nom;
            $OrgProProf = OrganisationProfessionnel::select('id')->where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->get();
            $lien = OrganisationProfessionnel::find($OrgProProf);
            #dd($lien[0]->numMembre);
            $this->numMembre = $lien[0]->numMembre;
            $this->dateExpiration = $lien[0]->dateExpiration;
            $this->idOrgProProf = $lien[0]->id;
        }
        $this->dispatch('open-modal', name: 'modifierOrg');
    }

    public function ajoutOrg()
    {
        $this->validate();

        $professionFound = False;
        $this->professions = Profession::all();
        foreach ($this->professions as $p) {
            if ($this->profession == $p->nom) {
                $this->idProfession = $p->id;
                $professionFound = True;
                break;
            }
        }
        if ($professionFound == False && $this->profession != null) {
            $this->idProfession = Profession::insertGetId([
                'nom' => $this->profession,
            ]);
        }
        if ($this->profession == " ") {
            $this->idProfession = null;
        }

        $organisationFound = False;
        $this->organisations = Organisation::all();
        foreach ($this->organisations as $o) {
            if ($this->organisation == $o->nom) {
                $this->idOrganisation = $o->id;
                $organisationFound = True;
                break;
            }
        }
        if ($organisationFound == False && $this->organisation != null) {
            $this->idOrganisation = Organisation::insertGetId([
                'nom' => $this->organisation,
            ]);
        }
        if ($this->organisation == " ") {
            $this->idOrganisation = null;
        }

        #ajout lien professionnel et profession
        $profPro = ProfessionProfessionnel::where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->get();
        #dd($profPro->value('items'));
        if ($profPro->value('items') == null) {
            ProfessionProfessionnel::create([
                'idProfession' => $this->idProfession,
                'user_id' => Auth::user()->id
            ]);
        }

        #ajout lien organisation et profession
        $orgProf = OrganisationProfession::where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->get();
        if ($orgProf->value('items') == null) {
            OrganisationProfession::create([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation
            ]);
        }

        #ajout lien professionnel, profession et organisation
        $orgProfPro = OrganisationProfessionnel::where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->where('idProfessionnel', '=', Auth::user()->id)->get();
        if ($orgProfPro->value('items') == null && $this->organisation != null) {
            OrganisationProfessionnel::create([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation,
                'idProfessionnel' => Auth::user()->id,
                'numMembre' => $this->numMembre,
                'dateExpiration' => $this->dateExpiration
            ]);
        }
        $this->reset(['dateExpiration', 'numMembre', 'idOrganisation', 'idProfession', 'organisation', 'profession']);
        $this->orgPro = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->get();
        $this->idOrg = OrganisationProfessionnel::select('idOrganisation')->where('idProfessionnel', '=', Auth::user()->id)->get();
        $this->org = Organisation::whereIn('id', $this->idOrg)->get();
        $this->professions = Profession::all();
        $this->professionsPro = ProfessionProfessionnel::where('user_id', '=', Auth::user()->id)->get();
        $this->organisations = Organisation::all();
        $this->dispatch('close-modal');
    }

    public function modifOrg()
    {
        $this->validate();

        $professionFound = False;
        $this->professions = Profession::all();
        foreach ($this->professions as $p) {
            if ($this->profession == $p->nom) {
                $this->idProfession = $p->id;
                $professionFound = True;
                break;
            }
        }
        if ($professionFound == False && $this->profession != null) {
            $this->idProfession = Profession::insertGetId([
                'nom' => $this->profession,
            ]);
        }
        if ($this->profession == " ") {
            $this->idProfession = null;
        }

        $organisationFound = False;
        $this->organisations = Organisation::all();
        foreach ($this->organisations as $o) {
            if ($this->organisation == $o->nom) {
                $this->idOrganisation = $o->id;
                $organisationFound = True;
                break;
            }
        }
        if ($organisationFound == False && $this->organisation != null) {
            $this->idOrganisation = Organisation::insertGetId([
                'nom' => $this->organisation,
            ]);
        }
        if ($this->organisation == " ") {
            $this->idOrganisation = null;
        }

        #modif lien professionnel et profession
        if ($this->idProfessionPro == null) {
            $profPro = ProfessionProfessionnel::where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->get();
            #dd($profPro->value('items'));
            if ($profPro->value('items') == null) {
                ProfessionProfessionnel::create([
                    'idProfession' => $this->idProfession,
                    'user_id' => Auth::user()->id
                ]);
            }
        } else {
            ProfessionProfessionnel::find($this->idProfessionPro)->update([
                'idProfession' => $this->idProfession,
                'user_id' => Auth::user()->id,
            ]);
        }

        #modif lien organisation et profession
        if ($this->idOrganisationProf == null) {
            $orgProf = OrganisationProfession::where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->get();
            if ($orgProf->value('items') == null) {
                OrganisationProfession::create([
                    'idProfession' => $this->idProfession,
                    'idOrganisation' => $this->idOrganisation
                ]);
            }
        } else {
            OrganisationProfession::find($this->idOrganisationProf)->update([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation
            ]);
        }



        #modif lien professionnel, profession et organisation
        if ($this->idOrgProProf == null) {
            $orgProfPro = OrganisationProfessionnel::where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->where('idProfessionnel', '=', Auth::user()->id)->get();
            if ($orgProfPro->value('items') == null && $this->organisation != null) {
                OrganisationProfessionnel::create([
                    'idProfession' => $this->idProfession,
                    'idOrganisation' => $this->idOrganisation,
                    'idProfessionnel' => Auth::user()->id,
                    'numMembre' => $this->numMembre,
                    'dateExpiration' => $this->dateExpiration
                ]);
            }
        } else {
            OrganisationProfessionnel::find($this->idOrgProProf)->update([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation,
                'idProfessionnel' => Auth::user()->id,
                'numMembre' => $this->numMembre,
                'dateExpiration' => $this->dateExpiration
            ]);
        }


        $this->reset(['dateExpiration', 'numMembre', 'idOrganisation', 'idProfession', 'organisation', 'profession']);
        $this->orgPro = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->get();
        $this->idOrg = OrganisationProfessionnel::select('idOrganisation')->where('idProfessionnel', '=', Auth::user()->id)->get();
        $this->org = Organisation::whereIn('id', $this->idOrg)->get();
        $this->professions = Profession::all();
        $this->professionsPro = ProfessionProfessionnel::where('user_id', '=', Auth::user()->id)->get();
        $this->organisations = Organisation::all();
        $this->dispatch('close-modal');
    }
}
