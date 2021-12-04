import { Component, OnInit } from '@angular/core';
import { Profile } from 'src/app/models/Profile';
import { Router } from '@angular/router';
import { BackendService } from 'src/app/services/backend.service';


@Component({
    selector: 'app-settings',
    templateUrl: './settings.component.html',
    styleUrls: ['./settings.component.css']
})
export class SettingsComponent implements OnInit {

    public profile: Profile;

    public constructor(public router: Router, private backendservice: BackendService) {
        this.profile = new Profile('', '', '1', '', '1');
    }

    public ngOnInit(): void {
        this.backendservice.loadCurrentUser().then((user: any) => {
            if(user != null){
                this.profile.firstName = user.firstName ? user.firstName : '';
                this.profile.lastName = user.lastName ? user.lastName : '';
                this.profile.coffeeOrTea = user.coffeeOrTea ? user.coffeeOrTea : '1';
                this.profile.description = user.description ? user.description : '';
                this.profile.layout = user.layout ? user.layout : '1';
            }
        })
        console.log(this.profile.coffeeOrTea);
    }

    public saveSettings(): void{
        this.backendservice.saveCurrentUserProfile(this.profile)
        .then((result) => {
            if (result) {
                this.router.navigate(['/friends']);
            }
            else{
                console.log("Fehler beim Speichern des Profils");
            }
        })
    }

    public cancelSettings(): void{
        this.router.navigate(['/friends']);
    }
}
