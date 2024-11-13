<?php

namespace App\Livewire;

use App\Models\Organisation;
use App\Models\OrganisationProfessionnel;
use App\Models\OrganisationProfession;
use App\Models\ProfessionProfessionnel;
use App\Models\Profession;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public $prevOrg;


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


    public function formAjout()
    {
        $this->dispatch('open-modal', name: 'ajouterOrg');
    }

    public function formSup($lienOrgPro, $idProf, $idOrg)
    {
        $this->lienOrgPro = $lienOrgPro;
        $this->idProfession = $idProf;
        $this->professionPro = ProfessionProfessionnel::select('id')->where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->get();
        #$lienProfPro = ProfessionProfessionnel::find($this->professionPro);
        $this->idProfessionPro = $this->professionPro[0]->id;

        $this->idOrganisation = $idOrg;
        if ($this->idOrganisation != null) {
            $organisationProf = OrganisationProfession::select('id')->where('idOrganisation', '=', $this->idOrganisation)->where('idProfession', '=', $this->idProfession)->get();
            #$lienOrgProf = OrganisationProfession::find($organisationProf);
            #dd($lienOrgProf[0]->id);
            $this->idOrganisationProf = $organisationProf[0]->id;

            $OrgProProf = OrganisationProfessionnel::select('id')->where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->get();
            #$lien = OrganisationProfessionnel::find($OrgProProf);
            #dd($lien[0]->numMembre);
            $this->idOrgProProf = $OrgProProf[0]->id;
        }
        $this->dispatch('open-modal', name: 'supprimerOrg');
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
        $this->prevOrg = $idOrg;
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

        #ajout lien professionnel et profession
        $profPro = ProfessionProfessionnel::where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->get();
        #dd($profPro->value('items'));
        if (ProfessionProfessionnel::where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->exists()) {
            $this->idProfessionPro = $profPro[0]->id;

        } else {
            if ($this->idProfessionPro == null) {
                ProfessionProfessionnel::create([
                    'idProfession' => $this->idProfession,
                    'user_id' => Auth::user()->id
                ]);
            }
        }



        if ($this->idOrganisation != null) {
            #ajout lien organisation et profession
            $organisationProf = OrganisationProfession::where('idOrganisation', '=', $this->idOrganisation)->where('idProfession', '=', $this->idProfession)->get();

            #dd(empty($lienOrgProf->value('items')));
            if (OrganisationProfession::where('idOrganisation', '=', $this->idOrganisation)->where('idProfession', '=', $this->idProfession)->exists()) {
                $this->idOrganisationProf = $organisationProf[0]->id;

            } else {
                if ($this->idOrganisationProf == null) {
                    OrganisationProfession::create([
                        'idProfession' => $this->idProfession,
                        'idOrganisation' => $this->idOrganisation
                    ]);
                }
            }


            #ajout lien professionnel, profession et organisation
            $OrgProProf = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->get();

            if (OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->idOrganisation)->exists()) {
                $this->idOrgProProf = $OrgProProf[0]->id;

            } else {
                if ($this->idOrgProProf == null && $this->organisation != null) {
                    OrganisationProfessionnel::create([
                        'idProfession' => $this->idProfession,
                        'idOrganisation' => $this->idOrganisation,
                        'idProfessionnel' => Auth::user()->id,
                        'numMembre' => $this->numMembre,
                        'dateExpiration' => $this->dateExpiration
                    ]);
                }
            }

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
        $profPro = ProfessionProfessionnel::where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->get();
        #dd($profPro->value('items'));

        #dd($lienProfPro[0]->id);
        if (ProfessionProfessionnel::where('idProfession', '=', $this->idProfession)->where('user_id', '=', Auth::user()->id)->exists()) {

            $this->idProfessionPro = $profPro[0]->id;

            ProfessionProfessionnel::find($this->idProfessionPro)->update([
                'idProfession' => $this->idProfession,
                'user_id' => Auth::user()->id,
            ]);

        } else {
            $this->idProfessionPro = ProfessionProfessionnel::insertGetId([
                'idProfession' => $this->idProfession,
                'user_id' => Auth::user()->id
            ]);
        }

        #modif lien organisation et profession
        $organisationProf = OrganisationProfession::where('idOrganisation', '=', $this->idOrganisation)->where('idProfession', '=', $this->idProfession)->get();

        #dd(empty($lienOrgProf->value('items')));
        if (OrganisationProfession::where('idOrganisation', '=', $this->idOrganisation)->where('idProfession', '=', $this->idProfession)->exists()) {

            $this->idOrganisationProf = $organisationProf[0]->id;

            OrganisationProfession::find($this->idOrganisationProf)->update([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation
            ]);

        } else {

            $this->idOrganisationProf = OrganisationProfession::insertGetId([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation
            ]);
        }



        #modif lien professionnel, profession et organisation
        $OrgProProf = OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->prevOrg)->get();

        if (OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->where('idOrganisation', '=', $this->prevOrg)->exists()) {
            $this->idOrgProProf = $OrgProProf[0]->id;
            OrganisationProfessionnel::find($this->idOrgProProf)->update([
                'idProfession' => $this->idProfession,
                'idOrganisation' => $this->idOrganisation,
                'idProfessionnel' => Auth::user()->id,
                'numMembre' => $this->numMembre,
                'dateExpiration' => $this->dateExpiration
            ]);


        } else {
            if ($this->idOrgProProf == null && $this->organisation != null) {

                OrganisationProfessionnel::create([
                    'idProfession' => $this->idProfession,
                    'idOrganisation' => $this->idOrganisation,
                    'idProfessionnel' => Auth::user()->id,
                    'numMembre' => $this->numMembre,
                    'dateExpiration' => $this->dateExpiration
                ]);
            }
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

    public function supprimerOrg($sup)
    {
        if ($sup == "pro") {

            #dd(OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->count());
            if ($this->idProfessionPro != null && OrganisationProfessionnel::where('idProfessionnel', '=', Auth::user()->id)->where('idProfession', '=', $this->idProfession)->count() <= 1) {
                ProfessionProfessionnel::find($this->idProfessionPro)->delete();
            }

            if ($this->idOrgProProf != null) {
                OrganisationProfessionnel::find($this->idOrgProProf)->delete();
            }
        } elseif ($sup == "org") {

            if ($this->idOrgProProf != null) {
                OrganisationProfessionnel::find($this->idOrgProProf)->delete();
            }
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
