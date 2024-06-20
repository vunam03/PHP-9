class EventManager {
  #events;

  constructor() {
    this.#events = {};
  }

  registerEvent(eventName) {
    this.#events[eventName] = [];
  }

  registerActionToEvent(eventName, callbackFn) {
    const isEventRegistered = this.#events.hasOwnProperty(eventName);

    if (isEventRegistered) {
      this.#events[eventName].push(callbackFn);
      return;
    }

    throw `Event ${eventName} Not Registered`;
  }

  triggerEvent(eventName, params = []) {
    const isEventRegistered = this.#events.hasOwnProperty(eventName);

    if (isEventRegistered) {
      let eventActions = this.#events[eventName];

      eventActions.forEach((action) => {
        action(...params);
      });
      return;
    }

    throw `Event ${eventName} Not Registered`;
  }
}

export const eventManager = new EventManager();
