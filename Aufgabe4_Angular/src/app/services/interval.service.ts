import { Injectable } from '@angular/core';

@Injectable({
    providedIn: 'root'
})
/**
 * Singleton for starting and stopping background activities.
 */
export class IntervalService {

    private ids: Map<string, any> = new Map<string, any>(); // Map for component name -> interval ID
    private intervalTime = 2000; // period in seconds

    public constructor() { 
        console.log('*** interval service created ***');
    }

    public setInterval(componentName: string, lambda: () => void): void {
        if (!this.ids.has(componentName)) {
            // start interval with lambda, repeat every <intervalTime> ms
            // remember interval ID for clearIntervals()
            lambda();
            const intervalID = setInterval(lambda, this.intervalTime);
            this.ids.set(componentName, intervalID); 
            console.log(`${componentName} component: activating interval ID = ${JSON.stringify(intervalID)}`);
        }
    }

    public clearIntervals(): void {
        for (let componentName of this.ids.keys()) {
            const intervalID = this.ids.get(componentName);
            console.log(`${componentName} component: removing interval ID = ${JSON.stringify(intervalID)}`);
            clearInterval(intervalID);
        }
        this.ids = new Map<string, any>();
    }
}
