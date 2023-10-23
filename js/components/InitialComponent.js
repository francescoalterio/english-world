import { $, element } from "../tools.js";

export function InitialComponent({ $container }) {
  const $buttonStart = element("button");
  $buttonStart.setAttribute("id", "start");
  $buttonStart.textContent = "Click anywhere to start the round";
  $buttonStart.setAttribute("type", "submit");

  $container.append($buttonStart);
}
