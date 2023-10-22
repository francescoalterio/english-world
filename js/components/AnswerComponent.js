import { $, element } from "../tools.js";

export function AnswerComponent({ $container, wordData }) {
  const $pWord = element("p");
  const $pUserTranslate = element("p");
  const $pTranslate = element("p");
  const $button = element("button");

  $pWord.textContent = `Word: ${wordData.word}`;
  $pUserTranslate.textContent = `Your Translation: ${wordData["user-translation"]}`;
  $pTranslate.textContent = `Translation: ${wordData.translate}`;
  $button.textContent = "Next question";
  $button.setAttribute("type", "submit");

  $container.append($pWord, $pUserTranslate, $pTranslate, $button);
}
